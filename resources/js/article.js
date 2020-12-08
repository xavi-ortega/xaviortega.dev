import { Form } from './utils/form';

const thumbsUpElement = document.getElementById('thumbs-up');
const thumbsDownElement = document.getElementById('thumbs-down');
const article_id = document.querySelector("input[name='article_id']").value;

const commentForm = new Form('comment-form');

commentForm.addField('author');
commentForm.addField('body');
commentForm.addRule('body', (value) => value && value.length);
commentForm.addRule('userMustVote', () => thumbsUp || thumbsDown);

let thumbsUp = false;
let thumbsDown = false;

thumbsUpElement.addEventListener('click', () => {
    if(thumbsDown) {
        thumbsDown = false;
        thumbsDownElement.classList.remove('text-danger');
        let dislikes = parseInt(thumbsDownElement.nextSibling.textContent.trim());
        dislikes--;

        thumbsDownElement.nextSibling.textContent = ` ${dislikes}`;
    }

    if(!thumbsUp) {
        thumbsUp = true;
        thumbsUpElement.classList.add('text-primary');
        let likes = parseInt(thumbsUpElement.nextSibling.textContent.trim());
        likes++;

        thumbsUpElement.nextSibling.textContent = ` ${likes}`;
    }
});

thumbsDownElement.addEventListener('click', () => {
    if(thumbsUp) {
        thumbsUp = false;
        thumbsUpElement.classList.remove('text-primary');
        let likes = parseInt(thumbsUpElement.nextSibling.textContent.trim());
        likes--;

        thumbsUpElement.nextSibling.textContent = ` ${likes}`;
    }

    if(!thumbsDown) {
        thumbsDown = true;
        thumbsDownElement.classList.add('text-danger');
        let dislikes = parseInt(thumbsDownElement.nextSibling.textContent.trim());
        dislikes++;

        thumbsDownElement.nextSibling.textContent = ` ${dislikes}`;
    }
});

const errorFeedback = document.getElementById('error-feedback');

commentForm.onSubmit((data) => {
    if(commentForm.isValid()) {
        hideErrors();

        if(thumbsUp) {
            data.pleased = true;
        } else if(thumbsDown) {
            data.pleased = false;
        }

        axios.post(`article/${article_id}/comment`, data).then(response => {
            if(response.data.success) {
                const commentEl = document.createElement('div');
                commentEl.classList.add('comment', 'mb-3');
                let innerHTML = `<div class="comment-header mb-3">
                    <div class="comment-metadata">
                        <span>${data.author || 'Annonymous'}</span> &nbsp;•&nbsp; Now
                    </div>`;
                if(data.pleased) {
                    innerHTML += `<i class="fas fa-thumbs-up text-primary" title="${data.author || 'Annonyous'} loved the article" id="thumbs-up"></i>`
                } else {
                    innerHTML += `<i class="fas fa-thumbs-down text-danger" title="${data.author || 'Annonyous'} wasn't pleased by article" id="thumbs-down"></i>`;
                }

                innerHTML += `</div>
                <div class="comment-body">
                    ${data.body}
                </div>`;

                commentEl.innerHTML = innerHTML;

                commentForm.form.after(commentEl);

                commentForm.reset();
                resetFeedback();
            }
        });
    } else {
        showErrors(commentForm.getErrors());
    }
});

function hideErrors() {
    errorFeedback.innerHTML = '';
    errorFeedback.style.display = 'none';
}

function showErrors(errors) {
    errorFeedback.innerHTML = '';
    errorFeedback.style.display = 'block';

    if(errors.includes('body')) {
        errorFeedback.innerHTML += `<p>Please, leave an opinion before submitting</p>`;
    }

    if(errors.includes('userMustVote')) {
        errorFeedback.innerHTML += `<p>Please, react to the article (<i class="fas fa-thumbs-up"></i> or <i class="fas fa-thumbs-down"></i>) before leaving an opinion</p>`;
    }
}

function resetFeedback() {
    thumbsUp = false;
    thumbsDown = false;
    thumbsUpElement.classList.remove('text-primary');
    thumbsDownElement.classList.remove('text-danger');
}
