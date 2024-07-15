Fiz o CRUD de pessoas com Nome, E-mail e Telefone, incluindo validações no front e no back-end.
Usei Laravel 9, jQuery, MySQL, Ajax, HTML e CSS, e adicionei Bootstrap para o layout, 
paginação dos registros e alguns cuidados extras com o layout para melhorar a experiência do usuário.

Comandos executados no terminal durante o projeto: 
	php artisan make:controller RegisterController
	php artisan make:migration create_registers_table
	php artisan migrate
	php artisan make:model Register
	php artisan route:list
	php artisan make:middleware CheckRequestMethod

Controller
	listRegister: Lista todos os registros.
	newRegister: Retorna a view para criar um novo registro.
	store: Armazena um novo registro no banco de dados.
	edit: Retorna a view para editar um registro específico.
	update: Atualiza os dados de um registro existente.
	destroy: Exclui um registro específico.


Rotas 
	GET /: Página inicial.
	GET /registros: Lista todos os registros.
	GET /registro/novo: Exibe o formulário para criar um novo registro.
	POST /registro: Armazena um novo registro.
	GET /registro/{id}/editar: Exibe o formulário para editar um registro existente.
	PUT /registro/{id}: Atualiza um registro existente.
	DELETE /registro/{id}: Exclui um registro existente.

Jquery
	Utilizado nas validações dos formulários.

Ajax
	Utilizado nas requisições de novo cadastro e para excluir cadastro existente. 
