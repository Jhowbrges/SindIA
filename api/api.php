<?php

// Dados da API do ChatGPT
putenv("OPENAI_API_KEY=$_ENV[OPENAI_API_KEY]");
$apiKey = $_ENV['OPENAI_API_KEY'];
$api_url = 'https://api.openai.com/v1/chat/completions';

// Obter a mensagem do usuário do corpo da requisição
$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);
$userMessage = $data['userMessage'];
$roles_file = 'roles.json';
$roles_data = file_get_contents($roles_file);
$roles = json_decode($roles_data, true);

// Montar a estrutura da conversa
$messages = array(
    array('role' => 'system', 'content' => 'Na primeira mensagem, você se apresenta. Você é um chatbot chamado SindIA (junção de sindico com IA) que ajuda com dúvidas de administração condominial. Somente responda mensagens relacionadas ao tema.
    Informações que são importantes.
    Nome do condominio é: Condominio Edificio Elza Soares.
    Historia do Edificio:
    "O Edificio é resultado de uma luta popular, que se iniciou nos movimentos de base dos grupos de luta por moradia.
    Originalmente este edificio era um grande hotel de luxo, chamado Lord Hotel, que ficava no coração da Santa Cecila, regição central de São Paulo.
    Após decadas de decadencia e posteriormente abando, o predio foi ocupado pelo FML (Frente de Luta por Moradia).
    Após anos de ocupação e luta, o prédio foi desocupado e se transformou num projeto de moradia social.
    O Edificio recebeu o nome de Elza Soares em homenagem a cantora, que um dia foi barrada de se hospedar no extinto Lord Hotel, por racismo."
    O condominio ainda não possui CNPJ.
    O pagamento do condominio está sendo pela conta da associação.
    Não temos Piscina.
    Por enquanto o terraço está desativado.
    Valor do condominio:
    "R$200 as kitnets.
    R$250 os ap de 1 quarto.
    R$350 os ap de 2 quartos."
    Regra do parquinho: "O horario para uso do parquinho é das 10h às 18h. As crianças devem estar acompanhadas de pelo menos 1 responsável."
    Regra do terraço: "Por enquanto o terraço está desativado. Estamos aguardando a festa de inauguração e a colocação das cameras de segurança."
    Regra das áreas comuns: "Não é permitido deixar as crianças sozinhas nas áreas comuns. Também não é permitido deixar objetos como: movéis, plantas e preservar a limpeza (faça um texto elaborado sobre o assunto)."
    Planta dos apartamentos: A planta dos apartamentos pode ser solicitado ao sindico(a), que tem um prazo de um mês para enviar.
    Regra da churrasqueira: "A churrasqueira fica no terraço, que por enquanto está desativado."



'),
    array('role' => 'user', 'content' => $userMessage)
);
/*
$messages = array();

foreach ($roles as $role_data) {
    $role = $role_data['role'];
    $content = $role_data['content'];
    $messages[] = array('role' => $role, 'content' => $content);
}
*/

// Montar os dados para a chamada à API
$api_data = array(
    'model' => 'gpt-3.5-turbo',
    'messages' => $messages
);

$options = array(
    'http' => array(
        'header'  => "Content-type: application/json\r\nAuthorization: Bearer $api_key",
        'method'  => 'POST',
        'content' => json_encode($api_data)
    )
);

function searchConvention($userMessage) {
    // Adiciona regras de convenção coletiva do cond.
    $conventionData = array(
        'regra_parquinho' => 'O horario para uso do parquinho é das 10h às 18h. As crianças devem estar acompanhadas de pelo menos 1 responsável.',
        'regra_terraço' => 'Por enquanto o terraço está desativado. Estamos aguardando a festa de inauguração e a colocação das cameras de segurança.',
    );

    // Procurar palavras-chave no usuário mensagem 
    foreach ($conventionData as $keyword => $info) {
        $normalizedKeyword = str_replace('_', ' ', strtolower($keyword));
        if (stripos($userMessage, $normalizedKeyword) !== false) {
            return $info;
        }
    }
}

$context = stream_context_create($options);
$response = file_get_contents($api_url, false, $context);
$result = json_decode($response, true);

// Extrair a resposta do chatbot
$chatbotReply = $result['choices'][0]['message']['content'];
$chatbotReply = nl2br($chatbotReply);

// Verificar se a mensagem do usuário está relacionada à convenção coletiva
$relatedConventionInfo = searchConvention(strtolower($userMessage));
if ($relatedConventionInfo) {
    $chatbotReply = $relatedConventionInfo;
}

// Retornar a resposta em formato JSON
$response_data = array('reply' => $chatbotReply);
header('Content-Type: application/json');
echo json_encode($response_data);

?>
