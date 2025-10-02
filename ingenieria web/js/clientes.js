// clientes.js

document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);

    // --- SweetAlert al agregar cliente ---
    if (urlParams.has('success')) {
        Swal.fire({
            icon: 'success',
            title: '¡Cliente agregado!',
            text: 'El cliente fue registrado exitosamente',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            window.history.replaceState({}, document.title, window.location.pathname);
        });
    }

    if (urlParams.has('error')) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un problema al registrar el cliente',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Cerrar'
        }).then(() => {
            window.history.replaceState({}, document.title, window.location.pathname);
        });
    }

    // --- Confirmación antes de eliminar cliente ---
    document.querySelectorAll('.btnEliminar').forEach(boton => {
        boton.addEventListener('click', function (e) {
            e.preventDefault();
            let url = this.getAttribute('href');

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Este cliente será eliminado permanentemente",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    });

    // --- Alerta después de eliminar ---
    if (urlParams.has('deleted')) {
        if (urlParams.get('deleted') == '1') {
            Swal.fire({
                icon: 'success',
                title: '¡Eliminado!',
                text: 'El cliente fue eliminado correctamente',
                confirmButtonColor: '#3085d6'
            }).then(() => {
                window.history.replaceState({}, document.title, window.location.pathname);
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo eliminar el cliente',
                confirmButtonColor: '#d33'
            }).then(() => {
                window.history.replaceState({}, document.title, window.location.pathname);
            });
        }
    }

    // --- Alerta después de editar ---
    if (urlParams.has('updated')) {
        if (urlParams.get('updated') == '1') {
            Swal.fire({
                icon: 'success',
                title: '¡Actualizado!',
                text: 'Los datos del cliente se modificaron correctamente',
                confirmButtonColor: '#3085d6'
            }).then(() => {
                window.history.replaceState({}, document.title, window.location.pathname);
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo actualizar el cliente',
                confirmButtonColor: '#d33'
            }).then(() => {
                window.history.replaceState({}, document.title, window.location.pathname);
            });
        }
    }

    // --- Cargar datos en el modal Editar ---
    document.querySelectorAll(".btnEditar").forEach(btn => {
        btn.addEventListener("click", function () {
            document.getElementById("editId").value = this.dataset.id;
            document.getElementById("editNombre").value = this.dataset.nombre;
            document.getElementById("editApellido").value = this.dataset.apellido;
            document.getElementById("editCorreo").value = this.dataset.correo;
            document.getElementById("editCelular").value = this.dataset.celular;

            new bootstrap.Modal(document.getElementById("modalEditar")).show();
        });
    });

});
