let inputvalor = document.getElementById("valor");

inputvalor.addEventListener("input", function () {
    let valueValor = this.value.replace(/[^\d]/g, ""); // só números

    let inteiro = valueValor.slice(0, -2); // parte inteira
    let centavos = valueValor.slice(-2); // centavos

    // adiciona separador de milhar
    inteiro = inteiro.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

    let formattedValor = inteiro + "," + centavos;

    this.value = formattedValor;
});

document.querySelectorAll(".btnDelete").forEach(function (button) {
    button.addEventListener("click", function (event) {
        event.preventDefault;

        var deleteId = this.getAttribute("data-delete-id");

        Swal.fire({
            title: "Certeza?",
            text: "Você não conseguira reverter isso",
            icon: "warning",
            showCancelButton: true,
            cancelButtonColor: "#3085d6",
            confirmButtonColor: "#d33",
            confirmButtonText: "Excluir",
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("formExcluir" + deleteId).submit();
            }
        });
    });
});

$(function () {
    $(".select2").select2({
        theme: "bootstrap-5",
    });
});
