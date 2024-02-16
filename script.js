
document.getElementById('button').onclick = function () {
    var balanceParagraph = document.getElementById('balance');
    var messageParagraph = document.getElementById('message');
    var betNumber = parseInt(document.getElementById('betNumber').value);
    var betAmount = parseInt(document.getElementById('betAmount').value);
    var requestId = Date.now(); // Criando um ID único com base no timestamp atual

    if (isNaN(betNumber) || isNaN(betAmount)) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Por favor, insira um número válido para a aposta e o valor da aposta!',
            footer: '<a href="#">Por que estou vendo este aviso?</a>'
        });
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "rollDice.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            var result = response.result;
            var newBalance = response.balance;
            var message = response.message;

            if (response.code == 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Parabéns!',
                    text: 'Você ganhou ' + betAmount * 10 + '!',
                    timer: 1500
                });
            } else if (response.code == 0) {
                Swal.fire({
                    icon: 'info',
                    title: 'Tente novamente!',
                    text: 'Você não ganhou desta vez!',
                    timer: 500

                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Saldo insuficiente para realizar a aposta!',
                    footer: '<a href="#">Por que meu saldo é insuficiente?</a>',

                });
            }

            messageParagraph.textContent = message;
            balanceParagraph.textContent = "Saldo: " + newBalance;
            document.getElementById('placeholder').textContent = result;
        }
    };

    // Envia o número escolhido pelo usuário, o valor da aposta e o ID da requisição
    xhr.send("userNumber=" + betNumber + "&betAmount=" + betAmount + "&requestId=" + requestId);
};

function validateNumber(input) {
    if (input.value < 1) {
        input.value = 1;
    } else if (input.value > 6) {
        input.value = 6;
    }
}
function validateAmount(input) {
    if (input.value < 1) {
        input.value = 1;
    } else if (input.value > 100) {
        input.value = 6;
    }
}
