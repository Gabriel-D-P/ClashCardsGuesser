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

    // Botão Desistir
    const btnDesistir = document.getElementById('btn-desistir');
    if (btnDesistir) {
        btnDesistir.addEventListener('click', () => {
            const resultContainer = document.getElementById('resultado-container');
            let htmlOutput = "<div class='resultado'>";
            htmlOutput += `<h2>Você desistiu! 🏳️</h2>`;
            htmlOutput += `<img src='assets/imagens/${cartaSecretaNome}.png' class='correct' alt='${cartaSecretaNome}' style='width:150px; margin: 10px;'>`;
            htmlOutput += `<h3>A carta secreta era: <strong>${ucfirst(cartaSecretaNome)}</strong>!</h3>`;
            htmlOutput += `<button id='btn-reset'>Jogar Novamente</button>`;
            htmlOutput += "</div>";
            resultContainer.innerHTML = htmlOutput;
            document.getElementById('form-container').style.display = 'none';

            document.getElementById('btn-reset').addEventListener('click', function () {
                sessionStorage.removeItem('carta_secreta');
                location.reload();
            });
        });
    }
}

function handleTentativa(e) {
    e.preventDefault();
    const tentativaInput = document.getElementById('tentativa').value.trim().toLowerCase();
    const resultContainer = document.getElementById('resultado-container');

    if (!cartas[tentativaInput]) {
        resultContainer.innerHTML = `<div class='resultado'><strong>Carta "${tentativaInput}" não encontrada.</strong></div>`;
        return;
    }

    const btnDesistir = document.getElementById('btn-desistir');
    if (btnDesistir) btnDesistir.style.display = 'block';

    const cartaTentativa = cartas[tentativaInput];
    numeroTentativa++; // Conta em qual tentativa estamos
    let htmlOutput = "<div class='resultado'>";

    if (tentativaInput === cartaSecretaNome) {
        htmlOutput += `<h2>Você acertou na tentativa ${numeroTentativa}!</h2>`;
        htmlOutput += `<p class='correct flip-animation' style='animation-delay: 0s;'><strong>${ucfirst(tentativaInput)}</strong></p>`;
        htmlOutput += `<img src='assets/imagens/${tentativaInput}.png' class='correct flip-animation' alt='${tentativaInput}' style='width:150px; margin: 10px; animation-delay: 0.1s;'>`;

        let animationDelay = 0.2;
        atributos.forEach(atributo => {
            htmlOutput += `<p class='correct flip-animation' style='animation-delay: ${animationDelay}s;'><strong> <img src='assets/imagens/${atributo}.png' alt='${atributo}' style='width:16px; vertical-align:middle; width: 25px;'> ${ucfirst(atributo)}: </strong>${cartaSecreta[atributo]}</p>`;
            animationDelay += 0.1;
        });

        htmlOutput += `<h3 class='flip-animation' style='animation-delay: ${animationDelay}s;'>🎉 Parabéns! Você acertou a carta secreta: <strong>${ucfirst(cartaSecretaNome)}</strong>! 🎉</h3>`;
        animationDelay += 0.1;
        htmlOutput += `<button id='btn-reset' class='flip-animation' style='animation-delay: ${animationDelay}s;'>Jogar Novamente</button>`;

        document.getElementById('form-container').style.display = 'none';
    } else {
        htmlOutput += `<h2>Tentativa ${numeroTentativa}:</h2>`;
        htmlOutput += ucfirst(tentativaInput) + "<br>";
        htmlOutput += `<img src='assets/imagens/${tentativaInput}.png' alt='${tentativaInput}' class='flip-animation' style='width:150px; margin: 10px; animation-delay: 0s;'>`;

        let acertouTodos = true;
        let animationDelay = 0.1;

        atributos.forEach(atributo => {
            const valorSecreto = cartaSecreta[atributo];
            const valorTentado = cartaTentativa[atributo];
            const classe = (valorSecreto == valorTentado) ? 'correct' : 'incorrect';
            
            if (classe === 'incorrect') {
                acertouTodos = false;
            }

            htmlOutput += `<p class='${classe} flip-animation' style='animation-delay: ${animationDelay}s;'><strong> <img src='assets/imagens/${atributo}.png' alt='${atributo}' style='width:16px; vertical-align:middle; width: 25px;'> ${ucfirst(atributo)}: </strong> ${valorTentado}</p>`;
            animationDelay += 0.1;
        });

        if (acertouTodos) {
            htmlOutput += `<p class='flip-animation' style="background-color: #f39c12; color: white; justify-content: center; font-weight: bold; text-align: center; animation-delay: ${animationDelay}s;">Atributos iguais, mas a carta secreta é outra!</p>`;
        }
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
