const port = window.location.port ? ":" + window.location.port : "";
const mainUrl = window.location.protocol + "//" + window.location.hostname + port;
(document.querySelectorAll("[toast-list]") ||
    document.querySelectorAll("[data-choices]") ||
    document.querySelectorAll("[data-provider]")) &&
    (document.writeln(
        "<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/toastify-js'></script>"
    ),
    document.writeln(
        "<script type='text/javascript' src='"+mainUrl+"assets/libs/choices.js/public/assets/scripts/choices.min.js'></script>"
    ),
    document.writeln(
        "<script type='text/javascript' src='"+mainUrl+"assets/libs/flatpickr/flatpickr.min.js'></script>"
    ));
