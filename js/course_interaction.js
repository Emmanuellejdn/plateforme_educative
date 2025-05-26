// Gestion des commentaires et likes pour les cours
class CourseInteraction {
    constructor(courseId) {
        this.courseId = courseId;
        this.init();
    }

    init() {
        this.loadCourseStats();
        this.setupEventListeners();
    }

    setupEventListeners() {
        // Bouton like
        const likeBtn = document.getElementById('like-btn');
        if (likeBtn) {
            likeBtn.addEventListener('click', () => this.toggleLike());
        }

        // Formulaire de commentaire
        const commentForm = document.getElementById('comment-form');
        if (commentForm) {
            commentForm.addEventListener('submit', (e) => this.addComment(e));
        }

        // Boutons de suppression de commentaires
        this.setupDeleteButtons();
    }

    setupDeleteButtons() {
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('delete-comment-btn')) {
                const commentId = e.target.dataset.commentId;
                this.deleteComment(commentId);
            }
        });
    }

    async loadCourseStats() {
        try {
            const response = await fetch('../backend/comments_likes.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=get_course_stats&cours_id=${this.courseId}`
            });

            const data = await response.json();
            if (data.success) {
                this.updateLikeButton(data.user_liked, data.likes_count);
                this.displayComments(data.comments);
            }
        } catch (error) {
            console.error('Erreur lors du chargement des statistiques:', error);
        }
    }

    async toggleLike() {
        try {
            const response = await fetch('../backend/comments_likes.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=toggle_like&cours_id=${this.courseId}`
            });

            const data = await response.json();
            if (data.success) {
                this.updateLikeButton(data.liked, data.likes_count);
                this.showMessage(
                    data.action === 'added' ? 'Like ajouté !' : 'Like retiré !',
                    'success'
                );
            } else {
                this.showMessage(data.message, 'error');
            }
        } catch (error) {
            console.error('Erreur lors du toggle like:', error);
            this.showMessage('Erreur de connexion', 'error');
        }
    }

    async addComment(event) {
        event.preventDefault();
        
        const formData = new FormData(event.target);
        formData.append('action', 'add_comment');
        formData.append('cours_id', this.courseId);

        const contenu = formData.get('contenu').trim();
        if (!contenu) {
            this.showMessage('Veuillez saisir un commentaire', 'error');
            return;
        }

        try {
            const response = await fetch('../backend/comments_likes.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();
            if (data.success) {
                this.displayComments(data.comments);
                event.target.reset();
                this.showMessage('Commentaire ajouté avec succès !', 'success');
            } else {
                this.showMessage(data.message, 'error');
            }
        } catch (error) {
            console.error('Erreur lors de l\'ajout du commentaire:', error);
            this.showMessage('Erreur de connexion', 'error');
        }
    }

    async deleteComment(commentId) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')) {
            return;
        }

        try {
            const response = await fetch('../backend/comments_likes.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=delete_comment&comment_id=${commentId}`
            });

            const data = await response.json();
            if (data.success) {
                this.loadCourseStats(); // Recharger les commentaires
                this.showMessage('Commentaire supprimé', 'success');
            } else {
                this.showMessage(data.message, 'error');
            }
        } catch (error) {
            console.error('Erreur lors de la suppression:', error);
            this.showMessage('Erreur de connexion', 'error');
        }
    }

    updateLikeButton(userLiked, likesCount) {
        const likeBtn = document.getElementById('like-btn');
        const likesCountSpan = document.getElementById('likes-count');
        
        if (likeBtn) {
            likeBtn.classList.toggle('liked', userLiked);
            likeBtn.innerHTML = userLiked ? 
                '<i class="fas fa-heart"></i> J\'aime' : 
                '<i class="far fa-heart"></i> J\'aime';
        }
        
        if (likesCountSpan) {
            likesCountSpan.textContent = likesCount;
        }
    }

    displayComments(comments) {
        const commentsContainer = document.getElementById('comments-container');
        if (!commentsContainer) return;

        if (comments.length === 0) {
            commentsContainer.innerHTML = '<p class="no-comments">Aucun commentaire pour le moment.</p>';
            return;
        }

        const commentsHTML = comments.map(comment => {
            const date = new Date(comment.date_commentaire).toLocaleDateString('fr-FR', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            return `
                <div class="comment" data-comment-id="${comment.id}">
                    <div class="comment-header">
                        <span class="comment-author">${this.escapeHtml(comment.auteur)}</span>
                        <span class="comment-date">${date}</span>
                    </div>
                    <div class="comment-content">
                        ${this.escapeHtml(comment.contenu)}
                    </div>
                    <div class="comment-actions">
                        <button class="delete-comment-btn" data-comment-id="${comment.id}">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </div>
                </div>
            `;
        }).join('');

        commentsContainer.innerHTML = commentsHTML;
    }

    showMessage(message, type) {
        // Créer ou mettre à jour le conteneur de messages
        let messageContainer = document.getElementById('message-container');
        if (!messageContainer) {
            messageContainer = document.createElement('div');
            messageContainer.id = 'message-container';
            messageContainer.className = 'message-container';
            document.body.appendChild(messageContainer);
        }

        const messageDiv = document.createElement('div');
        messageDiv.className = `message message-${type}`;
        messageDiv.innerHTML = `
            <span>${message}</span>
            <button class="message-close" onclick="this.parentElement.remove()">×</button>
        `;

        messageContainer.appendChild(messageDiv);

        // Auto-suppression après 5 secondes
        setTimeout(() => {
            if (messageDiv.parentElement) {
                messageDiv.remove();
            }
        }, 5000);
    }

    escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
}

// Initialiser l'interaction pour le cours
document.addEventListener('DOMContentLoaded', function() {
    const courseIdElement = document.getElementById('course-id');
    if (courseIdElement) {
        const courseId = courseIdElement.value || courseIdElement.dataset.courseId;
        if (courseId) {
            new CourseInteraction(courseId);
        }
    }
});
