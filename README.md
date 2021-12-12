# aidsh

## How to install

> Clone the project
```
git clone https://github.com/mathisang/aidsh.git
```

> Prepare environment
```
cd aidsh
composer i
```

> Configure environment

*Edit the .env with your configuration*
```
DATABASE_URL="mysql://USER:PASSWORD@127.0.0.1:PORT/DATABASE?serverVersion=5.7"
```

> Create your database
```
./bin/console doctrine:database:create
./bin/console doctrine:migrations:migrate
```

> Load data
```
./bin/console doctrine:fixtures:load
```
Wait the fixtures generation

> Start server
```
./bin/console server:run
```

Then, go to [the administration](http://127.0.0.1:8000/admin) or [the API Documentation](http://127.0.0.1:8000/api)

> Login credentials
- ADMIN : ProfessorX / password
- SUPER_HERO : AgentZero8 / password
- CLIENT : *Look username of a client* / password

## Administration roles

### Administrator
- Manage all clients
- Manage all superheroes
- Manage all villains
- Can validate or decline a mission

### Superhero
- Access to all missions already accepted
- Access and update the status and the realisation date of his mission

### Client
- Create a mission
  - Choose villains and superheroes
- See his missions
- Update his missions with the status to validate
- Delete missions not started

## API

You can access to API only with a token generated with success login credentials
