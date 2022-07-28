# movement-ranking

## Como rodar
 - Clonar o repositório
 - Na raíz do repositório rodar o comando abaixo:
```
docker-compose up
```

## Portas
 - 4500 => API
 - 8080 => phpMyAdmin
    - user: root
    - pass: root
 - 3306 => MySQL

## Endpoints
 - movements - GET => Retorna todos Movements
 - ranking/\<idMovement\> - GET => Retorna o ranking do recorde pessoal de cada usuário no Movement
