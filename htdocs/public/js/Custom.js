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

function confirmarExclusao(event, contaId) {
    event.preventDefault();

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
            document.getElementById("formExcluir" + contaId).submit();
        }
    });
}
