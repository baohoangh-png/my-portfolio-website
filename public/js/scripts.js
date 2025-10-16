/*!
 * Start Bootstrap - SB Admin v7.0.7 (https://startbootstrap.com/template/sb-admin)
 * Copyright 2013-2023 Start Bootstrap
 * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
 */
//
// Scripts
//

window.addEventListener("DOMContentLoaded", (event) => {
    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector("#sidebarToggle");
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener("click", (event) => {
            event.preventDefault();
            document.body.classList.toggle("sb-sidenav-toggled");
            localStorage.setItem(
                "sb|sidebar-toggle",
                document.body.classList.contains("sb-sidenav-toggled")
            );
        });
    }
});

var exampleModal = document.getElementById("confirmdelete");
exampleModal.addEventListener("show.bs.modal", function (event) {
    var button = event.relatedTarget;

    var info = button.getAttribute("data-info");
    var action = button.getAttribute("data-action");

    var modalInfo = exampleModal.querySelector(".modal-body .info");

    modalInfo.innerHTML = "Bạn có đồng ý xóa: " + info;

    var modalForm = exampleModal.querySelector(".modal-content form");

    modalForm.action = action;
});
