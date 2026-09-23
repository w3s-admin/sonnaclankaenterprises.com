<script type="text/javascript">
// Universal CSRF protection: every POST form and every jQuery AJAX request
// automatically carries the per-session token from the <meta name="csrf-token">
// tag, so individual admin pages/forms don't each need to remember to add it.
(function () {
    var tokenMeta = document.querySelector('meta[name="csrf-token"]');
    var token = tokenMeta ? tokenMeta.getAttribute('content') : '';

    document.addEventListener('submit', function (e) {
        var form = e.target;
        if (!form || !form.tagName || form.tagName.toLowerCase() !== 'form') {
            return;
        }
        var method = (form.getAttribute('method') || 'get').toLowerCase();
        if (method !== 'post') {
            return;
        }
        if (form.querySelector('input[name="_csrf"]')) {
            return;
        }
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = '_csrf';
        input.value = token;
        form.appendChild(input);
    }, true);

    if (window.jQuery) {
        jQuery(document).ajaxSend(function (event, jqXHR) {
            jqXHR.setRequestHeader('X-CSRF-Token', token);
        });
    }
})();
</script>
