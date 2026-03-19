(function () {
    let devtoolsOpen = false;

    const threshold = 160;

    setInterval(() => {
        if (window.outerWidth - window.innerWidth > threshold ||
            window.outerHeight - window.innerHeight > threshold) {

            if (!devtoolsOpen) {
                devtoolsOpen = true;

                fetch("/report.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        type: "devtools_open",
                        time: Date.now()
                    })
                });
            }
        } else {
            devtoolsOpen = false;
        }
    }, 1000);

    // detect console usage
    const element = new Image();
    Object.defineProperty(element, 'id', {
        get: function () {
            fetch("/report.php", {
                method: "POST",
                body: JSON.stringify({ type: "console_detected" })
            });
        }
    });
    console.log(element);
})();
