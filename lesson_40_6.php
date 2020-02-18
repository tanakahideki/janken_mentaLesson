<?php

// 40 じゃんけんを作成しよう！
// 下記の要件を満たす「じゃんけんプログラム」を開発してください。
// 要件定義
// ・使用可能な手はグー、チョキ、パー
// ・勝ち負けは、通常のじゃんけん
// ・PHPファイルの実行はコマンドラインから。
// ご自身が自由に設計して、プログラムを書いてみましょう！

// 修正箇所
// 定数宣言をファイル冒頭に移動
// rematch関数を返り値で取得して、再帰関数を再帰する関数の中にかきました。
// resultやynを定数で管理するようにしました。

const STONE = 0;
const SCISSORS = 1;
const PAPER = 2;

const HAND_TYPE = [
    STONE => 'グー',
    SCISSORS => 'チョキ',
    PAPER => 'パー',
];

const DRAW = 0;
const LOSE = 1;
const WIN = 2;

const RESULT = [
    DRAW => 'あいこ',
    LOSE => '負け',
    WIN => '勝ち',
];

const YES = 'y';
const NO = 'n';

const REPLY = [
    YES => 'はい',
    NO => 'いいえ',
];


function janken() {
    echo "じゃんけんしましょう。使用可能な手はグー、チョキ、パーです。" . PHP_EOL;
    echo "グーなら0、チョキは1、パーは2を入力してください。" . PHP_EOL;

    $myhand = inputHand();
    $comhand = getComHand();

    echo "あなた:" . HAND_TYPE[$myhand] . " こちら:" . HAND_TYPE[$comhand] . PHP_EOL;

    $result = judge($myhand, $comhand);
    show($result);

    echo "じゃんけんを続けますか？" . PHP_EOL;
    echo "続ける場合はyを、終了する場合はnを入力してください。" . PHP_EOL;
    $isContinue = rematch();
    if(!$isContinue) {
        return janken();
    }
}

function inputHand() {
    $input = trim(fgets(STDIN));

    $checkMyhand = checkMyhand($input);
    if(!$checkMyhand) {
        return inputHand();
    }

    return $input;
}

function checkMyhand($input) {

    if(empty($input) && "0" !== $input) {
        echo "空です。グーなら0、チョキは1、パーは2を入力してください。" . PHP_EOL;
        return false;
    } elseif(!is_numeric($input)) {
        echo "グーなら0、チョキは1、パーは2を入力してください。" . PHP_EOL;
        return false;
    }

    if($input == STONE || $input == SCISSORS || $input == PAPER) {
        return true;
    } else {
        echo "グーなら0、チョキは1、パーは2を入力してください。" . PHP_EOL;
        return false;
    }

}

function getComHand() {
    $comhand = mt_rand(0, 2);
    
    return $comhand;
}

function judge($myhand, $comhand) {
    // $myhandのデータ型がstrで$monhandがintだが計算はできている
    $calculation = ($myhand - $comhand + 3) %3;

    return $calculation;
}

function show($result) {

    if($result == DRAW || $result == LOSE || $result == WIN) {
        echo "結果:" . RESULT[$result] . PHP_EOL;
    }

}

function rematch() {

    $input = trim(fgets(STDIN));

    if($input == YES) {
        echo REPLY[$input] . PHP_EOL;
        return false;
    } elseif ($input == NO) {
        echo REPLY[$input] . PHP_EOL;
        echo "ありがとうございました。じゃんけんを終了します。" . PHP_EOL;
        return true;
    } else {
        echo "yかnを入力してください。". PHP_EOL;
        // ここの再帰関数はこれでよいのか
        return rematch();
    }
}

janken();