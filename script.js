
document.getElementById('button').onclick = function () {
    var balanceParagraph = document.getElementById('balance');
    var messageParagraph = document.getElementById('message');
    var betNumber = parseInt(document.getElementById('betNumber').value);
    var betAmount = parseInt(document.getElementById('betAmount').value);
    var requestId = Date.now(); 

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
    xhr.open("POST", "rollDice", true);
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
                    footer: '<a href="AddFunds">Adicione Saldo!</a>',

                });
            }
            messageParagraph.textContent = message;
            balanceParagraph.textContent = "Saldo: R$ " + newBalance;
            document.getElementById('placeholder').textContent = result;
        }
    };

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
