let insert = document.getElementById("insert");
let modificar = document.getElementById("modificar");
let modal_insert = document.getElementById("modal_insert");
let modal_update = document.getElementById("modal_update");
let container = document.getElementById("container");
let enviar = document.getElementById("enviar");
let nuevo = document.getElementById("nuevo");

const viewModalInsert = () => {
    modal_insert.style.display = "block";
    container.classList.add("bajar");
};

insert.addEventListener("click", viewModalInsert);

const removeModalInsert = () => {
    modal_insert.style.display = "none";
    container.classList.remove("bajar");
};

enviar.addEventListener("click", removeModalInsert);

const viewModalUpdate = () => {
    modal_update.style.display = "block";
    container.classList.add("bajar");
};

modificar.addEventListener("click", viewModalUpdate);

const removeModalUpdate = () => {
    modal_update.style.display = "none";
    container.classList.remove("bajar");
};

nuevo.addEventListener("click", removeModalUpdate);