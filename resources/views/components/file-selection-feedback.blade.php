<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('input[type="file"]').forEach(function (input) {
            if (input.dataset.fileFeedbackInitialized === 'true') {
                return;
            }

            input.dataset.fileFeedbackInitialized = 'true';

            const feedback = document.createElement('p');
            feedback.className = 'hidden mt-3 text-xs font-bold text-green-700 break-all';
            feedback.setAttribute('role', 'status');
            feedback.setAttribute('aria-live', 'polite');
            input.insertAdjacentElement('afterend', feedback);

            input.addEventListener('change', function () {
                const file = input.files && input.files.length > 0 ? input.files[0] : null;

                if (!file) {
                    feedback.textContent = '';
                    feedback.classList.add('hidden');
                    return;
                }

                feedback.textContent = '✓ Arquivo selecionado: ' + file.name;
                feedback.classList.remove('hidden');
            });
        });
    });
</script>
