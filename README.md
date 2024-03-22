# Integração com gateway de pagamentos

Devido à diversidade de gateways de pagamento disponíveis no mercado, cada um com seus próprios padrões de comunicação e API específica, surge a necessidade de uma solução que simplifique e padronize a integração desses serviços em diferentes projetos. É nesse contexto que surge a motivação para a utilização de bibliotecas como Omnipay, que oferecem um retorno padronizado independente do gateway utilizado.

Este projeto visa demonstrar o uso dessa biblioteca em conjunto com o gateway Stripe.

## Utilização

Para executar o projeto, siga os passos abaixo:

1. Acesse o terminal na raiz do projeto.
2. Execute o seguinte comando: 
    ```
    php -S localhost:5000 -t public
    ```

### Autorização

Para criar uma autorização, acesse a seguinte rota:
http://localhost:5000/PaymentController/getAuthorization
A resposta será exibida na tela. Caso a transação seja autorizada, a transactionReference deve ser salva para operações subsequentes.

### Captura

Para efetuar o pagamento, acesse a rota abaixo, passando a transactionReference obtida na etapa de autorização como parâmetro:
http://localhost:5000/PaymentController/getCapture/transactionReference

### Reembolso

Para solicitar o reembolso de uma transação, acesse a seguinte rota, passando a transactionReference como parâmetro:

http://localhost:5000/PaymentController/getRefund/transactionReference

### Cancelamento

Para cancelar uma transação, acesse a seguinte rota, passando a transactionReference como parâmetro:

http://localhost:5000/PaymentController/getVoid/transactionReference

## Testes
Foram realizados testes, eles se encontram na pasta tests/PaymentGatewayTest
## Requisitos

Este projeto requer PHP 8.2 e composer instalado em sua máquina.

