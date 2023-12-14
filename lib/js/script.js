let content = document.getElementById("content");
let films = document.getElementById("films");
let actor = document.getElementById("actor");

let reparto1 = document.getElementById("reparto1");
let volver1 = document.getElementById("volver1");
let reparto2 = document.getElementById("reparto2");
let reparto3 = document.getElementById("reparto3");
let reparto4 = document.getElementById("reparto4");
let reparto5 = document.getElementById("reparto5");

const viewToggle = () => {
    console.log("reparto");
    content.classList.add("move");
    actor.classList.add("mostrar");
}

reparto1.addEventListener("click", viewToggle);

const seeToggle = () => {
    console.log("volver");
    content.classList.remove("move");
    actor.classList.remove("mostrar");
}

volver1.addEventListener("click", seeToggle);