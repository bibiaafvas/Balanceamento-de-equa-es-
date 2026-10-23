# Balanceamento de Equações 

## OBJETIVOS 
Crie um site interativo chamado **BalanceQ**, desenvolvido para realizar o balanceamento de equações químicas de maneira simples, rápida e educativa.

Desenvolva uma interface moderna, organizada e intuitiva, utilizando cores relacionadas à química, como azul, branco e verde. Adicione elementos visuais de laboratório, moléculas e átomos para deixar o site atraente.

**Crie uma página inicial** com o nome BalanceQ, uma breve apresentação do aplicativo e um botão para começar a utilizar a ferramenta.

**Adicione um campo de texto** para que o usuário digite uma equação química, como H₂ + O₂ → H₂O. Inclua um botão chamado “Balancear Equação” para iniciar o processo.

**Implemente um sistema de balanceamento automático** que identifique os reagentes e os produtos, calcule os coeficientes estequiométricos corretos e apresente a equação balanceada, preservando as fórmulas químicas originais. Garanta que a quantidade de átomos de cada elemento seja igual nos dois lados da equação.

**Exiba o resultado de forma clara**, destacando os coeficientes adicionados e mostrando a equação antes e depois do balanceamento.

**Crie uma seção chamada “Passo a Passo”** para explicar como a equação foi balanceada. Mostre a quantidade de átomos de cada elemento nos reagentes e nos produtos, identifique os elementos que precisam ser ajustados e apresente as etapas utilizadas para chegar ao resultado final.

**Adicione uma seção de estudos** com explicações sobre o que são equações químicas, o princípio da conservação da massa, os reagentes, os produtos e os coeficientes estequiométricos.

**Inclua uma área de exercícios** com equações de diferentes níveis de dificuldade: fácil, médio e difícil. Permita que o usuário tente balancear as equações e receba uma mensagem indicando se acertou ou se precisa tentar novamente.

**Implemente mensagens de erro** para equações inválidas, fórmulas incompletas ou entradas que o sistema não consiga interpretar. Oriente o usuário a corrigir a equação antes de continuar.

**Adicione funcionalidades para limpar os campos, refazer cálculos e copiar os resultados** para a área de transferência.

Organize o site para funcionar em computadores e celulares. Garanta que os botões sejam funcionais, os cálculos sejam realizados corretamente e as explicações sejam fáceis de entender.

Utilize uma linguagem acessível para estudantes do Ensino Médio e de cursos técnicos em Química. Priorize a precisão científica, a facilidade de uso e o aprendizado do usuário.

**Crie um site funcional, e não apenas uma demonstração visual.** Implemente a lógica real de balanceamento químico, valide os resultados e garanta que cada equação apresentada esteja corretamente balanceada.

Finalize o projeto com um design profissional, responsivo e educativo, tornando o BalanceQ uma ferramenta útil para estudar, praticar e compreender o balanceamento de equações químicas.

### STACK TECNÓLOGICO
- Backend: PHP estruturado em sessões nativas
- Banco de dados: MySQL (PDO para segurança)
- Frontend: HTML5, PHP, CSS, Tailwind CSS

#### Regras de negocio (CORE) 

No nosso site temos o diferencial de ter um histórico que mostra os balanceamentos pedidos anteriormente. Também podem escolher entre modo automático ou manual, no automático o site mostra automaticamente a equação balanceada, no manual o site mostra e ensina passo a passo. é obrigatório o login com o gmail, também tem como salvar as equações que você quiser.


##### Regras globais
- Use sempre o mesmo PDO para conexão e queries no MySQL para evitar SQL Injections
- Mantenha o código limpo e comente apenas lógicas complexas.
- Separe os arquivos de forma lógica: um arquivo para conexão com a base (bd.php) e scripts de backend isolados em views em HTML5/PHP
- Estilize as telas em tailwind de forma responsiva priorizando o MobileFirst.


