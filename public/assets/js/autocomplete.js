$( function() {


    fetch('https://trefle.io/api/v1/plants/search?token=kJqCyqUGvVLbrVzGLfA7ZbVioh4E2NtD5YfX9C0roBM&q=*', {
        credentials: 'include', // Useful for including session ID (and, IIRC, authorization headers)
    })
        .then(response => response.json())
        .then(data => {
            console.log(data) // Prints result from `response.json()`
        })
        .catch(error => console.error(error))

    postRequest('https://trefle.io/api/v1/plants/search?token=kJqCyqUGvVLbrVzGLfA7ZbVioh4E2NtD5YfX9C0roBM&q=*', {user: 'Dan'})
        .then(data => console.log(data)) // Result from the `response.json()` call
        .catch(error => console.error(error))

    function postRequest(url, data) {
        return fetch(url, {
            credentials: 'same-origin', // 'include', default: 'omit'
            method: 'POST', // 'GET', 'PUT', 'DELETE', etc.
            body: JSON.stringify(data), // Coordinate the body type with 'Content-Type'
            headers: new Headers({
                'Content-Type': 'application/json'
            }),
        }).then(response => response.json())
    }

    var availableTags = [
        "ActionScript",
        "AppleScript",
        "Asp",
        "BASIC",
        "C",
        "C++",
        "Clojure",
        "COBOL",
        "ColdFusion",
        "Erlang",
        "Fortran",
        "Groovy",
        "Haskell",
        "Java",
        "JavaScript",
        "Lisp",
        "Perl",
        "PHP",
        "Python",
        "Ruby",
        "Scala",
        "Scheme"
    ];
    $( "#pot_Name" ).autocomplete({
        source: availableTags
    });
});