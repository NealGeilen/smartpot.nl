const app = document.querySelector("#root"),
    search = document.querySelector("#pot_Name"),
    btnSearch = document.querySelector("#search")

const photos = async (value, page, perpage) => {
    const container = document.createElement("div");
    container.setAttribute("class","row");
    app.appendChild(container);

    const settings = {
        method: "GET",
        headers: {
            "Content-type": "application/json",
            "Authorization": "563492ad6f917000010000013b49619a50604628af5d452c1bdcd84f"
        }
    }

    const URL = `https://api.pexels.com/v1/search/?page=${page}&per_page=${perpage}&query=${value}`;

    const response = await fetch(URL, settings);
    const data = await response.json();
    const photos = data.photos;

    let img_id = 0;

    if(response.status >= 200 && response.status < 400){
        photos.forEach(photo => {

            img_id++;

            const card = document.createElement("div");
            card.setAttribute("class","col-1");

            const img = document.createElement("img");
            img.setAttribute("id", img_id);
            img.setAttribute("class","image");
            img.addEventListener('click', update_url)

            img.src = photo.src.large;

            card.appendChild(img);
            container.appendChild(card);
        });
    }else{
        const err = document.createElement("h2");
        err.textContent = "Something went wrong / No images found!";
        app.appendChild(err)
    }
}
let value = document.getElementById("pot_Name").value;
let page = 1;
let perpage = 24;

function showPhotos(){
    const reset = document.querySelector(".row");
    app.removeChild(reset);
    photos(value,page,perpage);
}

btnSearch.addEventListener("click", (e) => {
    e.preventDefault();
    value = search.value.toLowerCase();
    if (value !== "") {
        showPhotos();
    }
});

function update_url(url) {
    var value = {'url':url.target.src};

    $.ajax({
        type: "POST",
        url: location.href,
        data: value
    });

    swal({
        title: 'Success',
        text: 'Image saved',
        type: 'success',
        buttonsStyling: false,
        confirmButtonClass: 'btn btn-info'
    }).then(
        $(".plant-background").css("background-image", "url('"+url.target.src+"')")
    )
}

photos(value,page,perpage);
