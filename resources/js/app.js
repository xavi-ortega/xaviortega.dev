window.axios = require("axios");

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

axios.defaults.baseURL = `/api`;

Prism.languages.tree = {
    // Highlight symbols used to denote folder structure
    'punctuation': /^([-|+`\s]+)/gm,

    // Highlight the individual file names
    'keyword':  /([a-zA-Z0-9._].+)/g
};

Prism.hooks.add('wrap', function(env) {
    // Add classnames for file extensions
    if (env.language === 'tree' && env.type === 'keyword') {
        var parts = env.content.split('.');
        while (parts.length > 1) {
            parts.shift();
            // Ex. 'foo.min.js' would become '<span class="token keyword ext-min-js ext-js">foo.min.js</span>'
            env.classes.push('ext-' + parts.join('-'));
        }
    }
});

Prism.highlightAll();
