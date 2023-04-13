<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Cooking.bo</title>
</head>
<body>
    <?php
        $prompt = $_POST["prompt"]??"O que tem na sua geladeira?";
    ?>
    <header>
        <h1>Bem Vindo ao <strong>Cooking.bo </strong><?="\u{1F36A}"?>!</h1>
        
    </header>
    <main>
        <h4>Basta falar quais ingredientes estão disponiveis em sua geladeira que irei te dar uma receita</h4>

        <div class="form">
            <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <input type="text" name="prompt" id="prompt" required value="<?= $prompt?>" placeholder="O que tem na sua geladeira">
                <input type="submit" value="Cozinhar">
            </form>
        </div>

        <section>
        <?php

            require __DIR__. '/vendor/autoload.php';
            require 'api_key.php';
            use Orhanerday\OpenAi\OpenAi;

            $open_ai = new OpenAI($apiKey);

            $prompt = isset($_POST['prompt']);

            if (isset($_POST["prompt"])){
            $complete = $open_ai->completion([
                'model' => 'text-davinci-003',
                'prompt' => 'uma receita que use somente esses ingredientes' . $_POST['prompt'],
                'temperature' => 0.7,
                'max_tokens' => 250,
                'frequency_penalty' => 0,
                'presence_penalty' => 0.6        
            ]);

            $response =json_decode($complete, true);
            $response = $response["choices"][0]["text"];
            echo "<p>$response</p>";
        }else{
            print"<p>Vamos cozinhar?</p>";
        }
        ?>

    </section>
    </main>

    
</body>
</html>