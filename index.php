<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adivinhe a Carta - Clash Royale</title>
    <style>
        .resultado .correct {
            background-color: #4caf50;
        }

        .resultado .incorrect {
            background-color: #e53935;
        }

        body {
            font-family: 'Press Start 2P', cursive;
            background-image: url('imagens/background.png');
            background-repeat: repeat;
            color: white;
            text-align: center;
            padding: 30px;
        }

        h1 {
            text-shadow: 2px 2px #000;
        }

        input[type="text"], input[type="submit"], button {
            padding: 10px;
            margin: 5px;
            width: 250px;
            cursor: pointer;
            border: 3px solid #222;
            background-color: #88c0d0;
            color: #000;
            font-family: 'Press Start 2P', cursive;
            box-shadow: 3px 3px #000;
        }

        input[type="submit"]:hover, button:hover {
            background-color: #a3d5e0;
        }

        .resultado {
            display: inline-block;
            background-color:rgb(31, 31, 31);
            border: 4px solid #000;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 5px 5px #000;
            margin-top: 20px;
        }

        .resultado p {
            background-color: #3a3a3a;
            border: 3px solid #000;
            border-radius: 5px;
            padding: 8px;
            margin: 5px 0;
            color: white;
            box-shadow: 2px 2px #000;
        }

        .mensagem {
            background-color: #3a3a3a;
            border: 3px solid #000;
            border-radius: 5px;
            padding: 8px;
            margin: 5px 0;
            color: white;
            box-shadow: 2px 2px #000;
        }

        .header {
            background-color: #333;
            border: 3px solid #000;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 2px 2px #000;
            margin-bottom: 10px;
        }

        .navbar {
            display: flex;
            background-color: #333;
        }

        .navbar a {
            flex: 1;
            color: white;
            text-align: center;
            padding: 14px 0;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .navbar a:hover {
            background-color: #575757;
        }

        /* Importando uma fonte pixelada */
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');
    </style>
</head>
<body>

<div class="navbar">
    <a href="index.php">Jogo</a>
    <a href="sobre.php">Sobre</a>
</div>

<h1>Adivinhe a Carta do Clash Royale</h1>

<?php
session_start();
if (!isset($_SESSION['historico'])) {
    $_SESSION['historico'] = [];
}

$cartas = [
    //? Elixir
    "espelho" => ["elixir" => "?", "raridade" => "Épica", "tipo" => "Feitiço", "unidades" => 1, "alvos" => "Nenhum", "alcance" => "-"],
        //1 Elixir
    "espírito de fogo" => ["elixir" => 1, "raridade" => "Comum", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "-"],
    "espírito de gelo" => ["elixir" => 1, "raridade" => "Comum", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "2,5"],
    "espírito elétrico" => ["elixir" => 1, "raridade" => "Comum", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "2,5"],
    "espírito de cura" => ["elixir" => 1, "raridade" => "Rara", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "2,5"],
    "esqueletos" => ["elixir" => 1, "raridade" => "Comum", "tipo" => "Tropa Terrestre", "unidades" => 3, "alvos" => "Terrestre", "alcance" => "Físico Próximo"],
    //2 Elixir
    "arbusto suspeito" => ["elixir" => 2, "raridade" => "Rara", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Construções", "alcance" => "-"],
    "barril de bárbaro" => ["elixir" => 2, "raridade" => "Épica", "tipo" => "Feitiço", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "4,5"],
    "berserker" => ["elixir" => 2, "raridade" => "Comum", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "Físico próximo"],
    "bombardeiro" => ["elixir" => 2, "raridade" => "Comum", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "4,5"],
    "bola de neve" => ["elixir" => 2, "raridade" => "Comum", "tipo" => "Feitiço", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "Toda arena"],
    "destruídores de muros" => ["elixir" => 2, "raridade" => "Épica", "tipo" => "Tropa Terrestre", "unidades" => 2, "alvos" => "Construções", "alcance" => "Físico próximo"],
    "morcegos" => ["elixir" => 2, "raridade" => "Comum", "tipo" => "Tropa Aérea", "unidades" => 5, "alvos" => "Aéreo/Terrestre", "alcance" => "Físico médio"],
    "goblins" => ["elixir" => 2, "raridade" => "Comum", "tipo" => "Tropa Terrestre", "unidades" => 4, "alvos" => "Terrestre", "alcance" => "Físico próximo"],
    "goblins lanceiros" => ["elixir" => 2, "raridade" => "Comum", "tipo" => "Tropa Terrestre", "unidades" => 3, "alvos" => "Aéreo/Terrestre", "alcance" => "5,5"],
    "golem de gelo" => ["elixir" => 2, "raridade" => "Rara", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Construções", "alcance" => "Físico próximo"],
    "fúria" => ["elixir" => 2, "raridade" => "Épica", "tipo" => "Feitiço", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "Toda arena"],
    "maldição goblin" => ["elixir" => 2, "raridade" => "Épica", "tipo" => "Feitiço", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "Toda arena"],
    "tronco" => ["elixir" => 2, "raridade" => "Lendária", "tipo" => "Feitiço", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "10,1"],
    "zap" => ["elixir" => 2, "raridade" => "Comum", "tipo" => "Feitiço", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "Toda arena"],
    //3 Elixir
    "megasservo" => ["elixir" => 3, "raridade" => "Rara", "tipo" => "Tropa Aérea", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "Físico distante"],
    "princesa" => ["elixir" => 3, "raridade" => "Lendária", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "9"],
    "mago de gelo" => ["elixir" => 3, "raridade" => "Lendária", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "5,5"],
    "cavaleiro" => ["elixir" => 3, "raridade" => "Comum", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "Físico médio"],
    "arqueiras" => ["elixir" => 3, "raridade" => "Comum", "tipo" => "Tropa Terrestre", "unidades" => 2, "alvos" => "Aéreo/Terrestre", "alcance" => "5"],
    "flechas" => ["elixir" => 3, "raridade" => "Comum", "tipo" => "Feitiço", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "Toda arena"],
    "barril de esqueletos" => ["elixir" => 3, "raridade" => "Comum", "tipo" => "Tropa Aérea", "unidades" => 1, "alvos" => "Construções", "alcance" => "-"],
    "gangue de goblins" => ["elixir" => 3, "raridade" => "Comum", "tipo" => "Tropa Terrestre", "unidades" => 6, "alvos" => "Aéreo/Terrestre", "alcance" => "-"],
    "goblin com dardo" => ["elixir" => 3, "raridade" => "Rara", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "6,5"],
    "canhão" => ["elixir" => 3, "raridade" => "Comum", "tipo" => "Construção", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "5,5"],
    "lápide" => ["elixir" => 3, "raridade" => "Rara", "tipo" => "Construção", "unidades" => 1, "alvos" => "Nenhum", "alcance" => "-"],
    "tornado" => ["elixir" => 3, "raridade" => "Épica", "tipo" => "Feitiço", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "5,5"],
    "golem de elixir" => ["elixir" => 3, "raridade" => "Rara", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Construções", "alcance" => "Físico próximo"],
    "barril de goblins" => ["elixir" => 3, "raridade" => "Épica", "tipo" => "Feitiço", "unidades" => 1, "alvos" => "Nenhum", "alcance" => "Toda arena"],
    "clone" => ["elixir" => 3, "raridade" => "Épica", "tipo" => "Feitiço", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "Toda arena"],
    "exército de esqueletos" => ["elixir" => 3, "raridade" => "Épica", "tipo" => "Tropa Terrestre", "unidades" => 15, "alvos" => "Terrestre", "alcance" => "-"],
    "servos" => ["elixir" => 3, "raridade" => "Comum", "tipo" => "Tropa Aérea", "unidades" => 3, "alvos" => "Aéreo/Terrestre", "alcance" => "Físico distante"],
    "guardas" => ["elixir" => 3, "raridade" => "Épica", "tipo" => "Tropa Terrestre", "unidades" => 3, "alvos" => "Terrestre", "alcance" => "Físico distante"],
    "mineiro" => ["elixir" => 3, "raridade" => "Lendária", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "Toda arena"],
    "bandida" => ["elixir" => 3, "raridade" => "Lendária", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "Físico próximo"],
    "fantasma real" => ["elixir" => 3, "raridade" => "Lendária", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "Físico médio"],
    "terremoto" => ["elixir" => 3, "raridade" => "Rara", "tipo" => "Feitiço", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "Toda arena"],
    "pescador" => ["elixir" => 3, "raridade" => "Lendária", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "Físico médio"],
    "pirotécnica" => ["elixir" => 3, "raridade" => "Comum", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "6"],
    "encomenda real" => ["elixir" => 3, "raridade" => "Comum", "tipo" => "Feitiço", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "3"],
    "pequeno príncipe" => ["elixir" => 3, "raridade" => "Campeão", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "5,5"],
    "vácuo" => ["elixir" => 3, "raridade" => "Épica", "tipo" => "Feitiço", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "Toda arena"],
    //4 Elixir
    "mineiro bombado" => ["elixir" => 4, "raridade" => "Campeão", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "Físico distante"],
    "rei esqueleto" => ["elixir" => 4, "raridade" => "Campeão", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "Físico médio"],
    "cavaleiro dourado" => ["elixir" => 4, "raridade" => "Campeão", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "Físico médio"],
    "bruxa mãe" => ["elixir" => 4, "raridade" => "Lendária", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "5,5"],
    "fênix" => ["elixir" => 4, "raridade" => "Lendária", "tipo" => "Tropa Aérea", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "Físico distante"],
    "goblin demolidor" => ["elixir" => 4, "raridade" => "Rara", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "5"],
    "caçador" => ["elixir" => 4, "raridade" => "Épica", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "4"],
    "máquina voadora" => ["elixir" => 4, "raridade" => "Rara", "tipo" => "Tropa Aérea", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "6"],
    "eletrocutadores" => ["elixir" => 4, "raridade" => "Rara", "tipo" => "Tropa Terrestre", "unidades" => 3, "alvos" => "Aéreo/Terrestre", "alcance" => "4,5"],
    "gigante das runas" => ["elixir" => 4, "raridade" => "Épica", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Construções", "alcance" => "Físico médio"],
    "bruxa sombria" => ["elixir" => 4, "raridade" => "Lendária", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "Físico distante"],
    "arqueiro mágico" => ["elixir" => 4, "raridade" => "Lendária", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "7"],
    "mago elétrico" => ["elixir" => 4, "raridade" => "Lendária", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "5"],
    "dragão infernal" => ["elixir" => 4, "raridade" => "Lendária", "tipo" => "Tropa Aérea", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "3,5"],
    "dragões esqueletos" => ["elixir" => 4, "raridade" => "Comum", "tipo" => "Tropa Aérea", "unidades" => 2, "alvos" => "Aéreo/Terrestre", "alcance" => "3,5"],
    "curadora guerreira" => ["elixir" => 4, "raridade" => "Rara", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "Físico distante"],
    "lenhador" => ["elixir" => 4, "raridade" => "Lendária", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "Físico próximo"],
    "gelo" => ["elixir" => 4, "raridade" => "Épica", "tipo" => "fetiço", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "Toda arena"],
    "fornalha" => ["elixir" => 4, "raridade" => "Rara", "tipo" => "Construção", "unidades" => 1, "alvos" => "Nenhum", "alcance" => "-"],
    "cabana de goblins" => ["elixir" => 4, "raridade" => "Rara", "tipo" => "Construção", "unidades" => 1, "alvos" => "Nenhum", "alcance" => "6"],
    "torre de bombas" => ["elixir" => 4, "raridade" => "Rara", "tipo" => "Construção", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "6"],
    "jaula de goblin" => ["elixir" => 4, "raridade" => "Rara", "tipo" => "Construção", "unidades" => 1, "alvos" => "Nenhum", "alcance" => "-"],
    "tesla" => ["elixir" => 4, "raridade" => "Comum", "tipo" => "Construção", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "5,5"],
    "escavadeira de goblins" => ["elixir" => 4, "raridade" => "Épica", "tipo" => "Construção", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "Toda arena"],
    "bola de fogo" => ["elixir" => 4, "raridade" => "Rara", "tipo" => "Feitiço", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "Toda arena"],
    "mosqueteira" => ["elixir" => 4, "raridade" => "Rara", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "6"],
    "mini pekka" => ["elixir" => 4, "raridade" => "Rara", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "Físico próximo"],
    "valquíria" => ["elixir" => 4, "raridade" => "Rara", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "Físico médio"],
    "príncipe das trevas" => ["elixir" => 4, "raridade" => "Épica", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "Físico médio"],
    "bebê dragão" => ["elixir" => 4, "raridade" => "Épica", "tipo" => "Tropa Aérea", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "3,5"],
    "veneno" => ["elixir" => 4, "raridade" => "Épica", "tipo" => "Feitiço", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "Toda arena"],
    "corredor" => ["elixir" => 4, "raridade" => "Rara", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Construções", "alcance" => "Físico próximo"],
    "aríete de batalha" => ["elixir" => 4, "raridade" => "Rara", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Construções", "alcance" => "Físico próximo"],
    "morteiro" => ["elixir" => 4, "raridade" => "Comum", "tipo" => "Construção", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "11,5"],
    //5 Elixir
    "rainha arqueira" => ["elixir" => 5, "raridade" => "Campeão", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "5"],
    "monge" => ["elixir" => 5, "raridade" => "Campeão", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "Físico médio"],
    "goblinstein" => ["elixir" => 5, "raridade" => "Campeão", "tipo" => "Tropa Terrestre", "unidades" => 2, "alvos" => "Aéreo/Terrestre", "alcance" => "5,5"],
    "máquina goblin" => ["elixir" => 5, "raridade" => "Lendária", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "Físico médio"],
    "patifes" => ["elixir" => 5, "raridade" => "Comum", "tipo" => "Tropa Terrestre", "unidades" => 3, "alvos" => "Aéreo/Terrestre", "alcance" => "Físico próximo"],
    "porcos reais" => ["elixir" => 5, "raridade" => "Rara", "tipo" => "Tropa Terrestre", "unidades" => 5, "alvos" => "Construções", "alcance" => "Físico próximo"],
    "domadora de carneiro" => ["elixir" => 5, "raridade" => "Lendária", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Construções", "alcance" => "Físico próximo"],
    "dragão elétrico" => ["elixir" => 5, "raridade" => "Épica", "tipo" => "Tropa Aérea", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "3,5"],
    "cemitério" => ["elixir" => 5, "raridade" => "Lendária", "tipo" => "Feitiço", "unidades" => 1, "alvos" => "Nenhum", "alcance" => "Toda arena"],
    "gigante" => ["elixir" => 5, "raridade" => "Rara", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Construções", "alcance" => "Físico médio"],
    "carrinho de canhão" => ["elixir" => 5, "raridade" => "Rara", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "5,5"],
    "príncipe" => ["elixir" => 5, "raridade" => "Épica", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "Físico distante"],
    "balão" => ["elixir" => 5, "raridade" => "Épica", "tipo" => "Tropa Aérea", "unidades" => 1, "alvos" => "Construções", "alcance" => "Físico próximo"],
    "mago" => ["elixir" => 5, "raridade" => "Rara", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "5,5"],
    "torre inferno" => ["elixir" => 5, "raridade" => "Rara", "tipo" => "Construção", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "6"],
    "executor" => ["elixir" => 5, "raridade" => "Épica", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "4,5"],
    "bruxa" => ["elixir" => 5, "raridade" => "Épica", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "5,5"],
    "bárbaros" => ["elixir" => 5, "raridade" => "Comum", "tipo" => "Tropa Terrestre", "unidades" => 5, "alvos" => "Terrestre", "alcance" => "Físico próximo"],
    "horda de servos" => ["elixir" => 5, "raridade" => "Comum", "tipo" => "Tropa Aérea", "unidades" => 6, "alvos" => "Aéreo/Terrestre", "alcance" => "Físico distante"],
    "lançador" => ["elixir" => 5, "raridade" => "Épica", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "4"],
    //6 Elixir
    "bandida líder" => ["elixir" => 6, "raridade" => "Campeão", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "Físico próximo"],
    "gigante real" => ["elixir" => 6, "raridade" => "Comum", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Construções", "alcance" => "5"],
    "goblin gigante" => ["elixir" => 6, "raridade" => "Épica", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Construções", "alcance" => "Físico médio"],
    "esqueleto gigante" => ["elixir" => 6, "raridade" => "Épica", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "Físico próximo"],
    "relâmpago" => ["elixir" => 6, "raridade" => "Épica", "tipo" => "Feitiço", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "Toda arena"],
    "coletor de elixir" => ["elixir" => 6, "raridade" => "Rara", "tipo" => "Construção", "unidades" => 1, "alvos" => "Nenhum", "alcance" => "-"],
    "foguete" => ["elixir" => 6, "raridade" => "Rara", "tipo" => "Feitiço", "unidades" => 1, "alvos" => "Aéreo/Terrestre", "alcance" => "Toda arena"],
    "x besta" => ["elixir" => 6, "raridade" => "Épica", "tipo" => "Construção", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "11,5"],
    "bárbaros de elite" => ["elixir" => 6, "raridade" => "Comum", "tipo" => "Tropa Terrestre", "unidades" => 2, "alvos" => "Terrestre", "alcance" => "Físico médio"],
    "cabana de bárbaros" => ["elixir" => 6, "raridade" => "Rara", "tipo" => "Construção", "unidades" => 1, "alvos" => "Nenhum", "alcance" => "-"],
    "sparky" => ["elixir" => 6, "raridade" => "Lendária", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "5"],
    //7 Elixir
    "recrutas reais" => ["elixir" => 7, "raridade" => "Comum", "tipo" => "Tropa Terrestre", "unidades" => 6, "alvos" => "Terrestre", "alcance" => "Físico distante"],
    "gigante elétrico" => ["elixir" => 7, "raridade" => "Épica", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Construções", "alcance" => "Físico médio"],
    "pekka" => ["elixir" => 7, "raridade" => "Épica", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "Físico médio"],
    "lava hound" => ["elixir" => 7, "raridade" => "Lendária", "tipo" => "Tropa Aérea", "unidades" => 1, "alvos" => "Construções", "alcance" => "3,5"],
    "mega cavaleiro" => ["elixir" => 7, "raridade" => "Lendária", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Terrestre", "alcance" => "Físico médio"],
    //8 Elixir
    "golem" => ["elixir" => 8, "raridade" => "Épica", "tipo" => "Tropa Terrestre", "unidades" => 1, "alvos" => "Construções", "alcance" => "Físico próximo"],
    //9 Elixir
    "três mosqueteiras" => ["elixir" => 9, "raridade" => "Rara", "tipo" => "Tropa Terrestre", "unidades" => 3, "alvos" => "Aéreo/Terrestre", "alcance" => "6"]
];

if (!isset($_SESSION['carta_secreta'])) {
    $nomes_cartas = array_keys($cartas);
    $nome_sorteado = $nomes_cartas[array_rand($nomes_cartas)];
    $_SESSION['carta_secreta'] = $nome_sorteado;
}

$carta_secreta_nome = $_SESSION['carta_secreta'];
$carta_secreta = $cartas[$carta_secreta_nome];
?>

<?php
// Só exibe o formulário se não acertou ainda
if (!isset($_POST['tentativa']) || strtolower(trim($_POST['tentativa'])) != $carta_secreta_nome) {
?>

<form method="post">
    <input type="text" name="tentativa" placeholder="Digite o nome da carta" required autocomplete="off" list="cartas">
    
    <datalist id="cartas">
        <?php
        foreach ($cartas as $nome => $info) {
            echo "<option value=\"" . ucfirst($nome) . "\"></option>";
        }
        ?>
    </datalist>

    <br>
    <input type="submit" value="Enviar tentativa">
</form>

<?php
}
if (isset($_POST['tentativa'])) {
    $tentativa = strtolower(trim($_POST['tentativa']));

    if (!array_key_exists($tentativa, $cartas)) {
        echo "<div class='resultado'><strong>Carta \"$tentativa\" não encontrada.</strong></div>";
    } else {
        $carta_tentativa = $cartas[$tentativa];

        echo "<div class='resultado'>";
        if ($tentativa == $carta_secreta_nome) {
            echo "<h2>Você acertou!</h2>";
            echo "<p class='correct'></strong> " . ucfirst($tentativa) . "</p>";
            echo "<img src='$tentativa.png' class='correct' alt='$tentativa' style='width:150px; border: 4px solid #000; box-shadow: 4px 4px #000; margin: 10px;'>";
            foreach (["elixir", "raridade", "tipo", "unidades","alvos", "alcance"] as $atributo) {
                echo "<p class='correct'><strong> <img src='$atributo.png' alt='$atributo' style='width:16px; vertical-align:middle; width: 25px;'> " . ucfirst($atributo) . ": </strong>" . $carta_secreta[$atributo] . "</p>";
            }
            echo "<h3>🎉 Parabéns! Você acertou a carta secreta: <strong>" . ucfirst($carta_secreta_nome) . "</strong>! 🎉</h3>";
            echo "<form method='post'><button name='reset'>Jogar Novamente</button></form>";
        } else {
            echo "<h2>Tentativa:</h2>";
            echo ucfirst($tentativa);
            echo'<br>';
            echo "<img src='$tentativa.png' alt='$tentativa' style='width:150px; border: 4px solid #000; box-shadow: 4px 4px #000; margin: 10px;'>";

            foreach (["elixir", "raridade", "tipo", "unidades","alvos", "alcance"] as $atributo) {
                $valor_secreto = $carta_secreta[$atributo];
                $valor_tentado = $carta_tentativa[$atributo];

                if ($valor_secreto == $valor_tentado){
                    $classe = 'correct'; }
                else {
                    $classe = 'incorrect';
                }

                echo "<p class='$classe'><strong> <img src='$atributo.png' alt='$atributo' style='width:16px; vertical-align:middle; width: 25px;'> " . ucfirst($atributo) . ": </strong> $valor_tentado</p>";
            }
        }
        echo "</div>";
    }
}

if (isset($_POST['reset'])) {
    unset($_SESSION['carta_secreta']);
    echo "<meta http-equiv='refresh' content='0'>";
}

?>
</body>
</html>
