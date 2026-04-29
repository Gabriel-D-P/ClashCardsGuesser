let cartas = {};
let cartaSecreta = null;
let cartaSecretaNome = null;
let numeroTentativa = 0;

// Pré-carregando os ícones dos atributos na memória para exibição instantânea
const atributos = ["elixir", "raridade", "tipo", "unidades", "alvos", "alcance"];
atributos.forEach(attr => {
    const img = new Image();
    img.src = `assets/imagens/${attr}.png`;
});

function ucfirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

document.addEventListener('DOMContentLoaded', () => {
    cartas = cartasData;
    iniciarJogo();
});

function iniciarJogo() {
    // Lógica da Sessão
    cartaSecretaNome = sessionStorage.getItem('carta_secreta');
    if (!cartaSecretaNome) {
        const nomesCartas = Object.keys(cartas);
        cartaSecretaNome = nomesCartas[Math.floor(Math.random() * nomesCartas.length)];
        sessionStorage.setItem('carta_secreta', cartaSecretaNome);
    }
    cartaSecreta = cartas[cartaSecretaNome];

    // Preenchendo o Datalist
    const datalist = document.getElementById('cartas-datalist');
    for (const nome in cartas) {
        const option = document.createElement('option');
        option.value = ucfirst(nome);
        datalist.appendChild(option);
    }

    // Formulário de Tentativa
    document.getElementById('jogo-form').addEventListener('submit', handleTentativa);
}

function handleTentativa(e) {
    e.preventDefault();
    const tentativaInput = document.getElementById('tentativa').value.trim().toLowerCase();
    const resultContainer = document.getElementById('resultado-container');

    if (!cartas[tentativaInput]) {
        resultContainer.innerHTML = `<div class='resultado'><strong>Carta "${tentativaInput}" não encontrada.</strong></div>`;
        return;
    }

    const cartaTentativa = cartas[tentativaInput];
    numeroTentativa++; // Conta em qual tentativa estamos
    let htmlOutput = "<div class='resultado'>";

    if (tentativaInput === cartaSecretaNome) {
        htmlOutput += `<h2>Você acertou na tentativa ${numeroTentativa}!</h2>`;
        htmlOutput += `<p class='correct'><strong>${ucfirst(tentativaInput)}</strong></p>`;
        htmlOutput += `<img src='assets/imagens/${tentativaInput}.png' class='correct' alt='${tentativaInput}' style='width:150px; border: 4px solid #000; box-shadow: 4px 4px #000; margin: 10px;'>`;

        atributos.forEach(atributo => {
            htmlOutput += `<p class='correct'><strong> <img src='assets/imagens/${atributo}.png' alt='${atributo}' style='width:16px; vertical-align:middle; width: 25px;'> ${ucfirst(atributo)}: </strong>${cartaSecreta[atributo]}</p>`;
        });

        htmlOutput += `<h3>🎉 Parabéns! Você acertou a carta secreta: <strong>${ucfirst(cartaSecretaNome)}</strong>! 🎉</h3>`;
        htmlOutput += `<button id='btn-reset'>Jogar Novamente</button>`;

        document.getElementById('form-container').style.display = 'none';
    } else {
        htmlOutput += `<h2>Tentativa ${numeroTentativa}:</h2>`;
        htmlOutput += ucfirst(tentativaInput) + "<br>";
        htmlOutput += `<img src='assets/imagens/${tentativaInput}.png' alt='${tentativaInput}' style='width:150px; border: 4px solid #000; box-shadow: 4px 4px #000; margin: 10px;'>`;

        atributos.forEach(atributo => {
            const valorSecreto = cartaSecreta[atributo];
            const valorTentado = cartaTentativa[atributo];
            const classe = (valorSecreto == valorTentado) ? 'correct' : 'incorrect';

            htmlOutput += `<p class='${classe}'><strong> <img src='assets/imagens/${atributo}.png' alt='${atributo}' style='width:16px; vertical-align:middle; width: 25px;'> ${ucfirst(atributo)}: </strong> ${valorTentado}</p>`;
        });
    }

    htmlOutput += "</div>";
    
    // Voltamos para innerHTML caso você queira sempre limpar a interface antes de inserir a nova carta.
    // Mostrar apenas UMA carta por vez ao invés de enfileirá-las.
    resultContainer.innerHTML = htmlOutput;

    // O botão reset só é inserido quando ganha, pegamos ele pra definir os eventos
    const btnReset = document.getElementById('btn-reset');
    if (btnReset) {
        btnReset.addEventListener('click', function () {
            sessionStorage.removeItem('carta_secreta');
            location.reload();
        });
    }
}
