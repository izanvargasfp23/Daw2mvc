class AdministarVistas{
    constructor(){
        this.enlaces = null;
        this.secciones = null;
        this.vista = null;
        this.productos = null;
    }

    inicializar(){
        fetch("http://localhost/Daw2mvc_IzanVargas/index.php?controller=Usuario&action=api")
        .then(respuesta => respuesta.json())
        .then(r => {
            this.productos = r;
            const tablaProductos = document.getElementById("productos");
            this.productos.forEach(p => {
                const tr = document.createElement("tr");
                const td1 = document.createElement("td");
                td1.textContent = p.id;
                tr.append(td1);
                const td2 = document.createElement("td");
                td2.textContent = p.nombre;
                tr.append(td2);
                const td3 = document.createElement("td");
                td3.textContent = p.precio;
                tr.append(td3);
                tablaProductos.append(tr)
            })
        })

        this.enlaces = document.querySelectorAll('a');
        this.secciones = document.querySelectorAll('section');

        this.enlaces.forEach((e) => {
            e.addEventListener('click', () => {
                console.log(e.dataset.view)
                this.vista = e.dataset.view;
                this.secciones.forEach((u) => {
                    if (u.dataset.view == e.dataset.view) {
                        //mostramos seccion correspondiente
                        u.hidden = false;
                    }else{
                        u.hidden = true;
                    }
                })
            })
        })
    }   
}

let admin = new AdministrarVistas()
admin.inicializar(); 

class Productos{
    constructor(id, nombre, precio){
        this.id = id;
        this.nombre = nombre;
        this.precio = precio;
    }

    eliminar(){
        fetch("controller donde esta la funcion API"),{
            method: "DELETE",
            body: JSON.stringify(this.id)
        }
        .then(r => r.json())
        .then(r => console.log(r))
    }

    crear(){
        //Crear producto
    }

    cambiar(id){
        //cambiar producto
    }


}

const formularioEliminarProducto = document.querySelector("#eliminarProducto");

formularioEliminarProducto.addEventListener("submit", (e) =>{
    e.preventDefault();
    const id = e.target[0].value;

    const producto = {
        id: id,
        nombre: "test"
    }

    fetch("controller donde esta la funcion API"),{
        method: "DELETE",
        body: JSON.stringify(producto)
    }
    .then(r => r.json())
    .then(r => console.log(r))
})