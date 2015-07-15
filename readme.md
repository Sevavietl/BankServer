# Bank Server

Simple server to make transactions with card. The actual API has two routes: `transaction/authenticate` and `transaction/bill`

##Installation:
1. Clone the repo.
2. Copy `.env.example` to `.env` file and provide your configurations there.
3. Create db:
```shell
touch storage/database/bank_server.db
```
4. Run migrations.
5. Run seeds.

## Usage:
There three routes:
- `transaction` - you can see the list of all transactions.
- `transaction/authenticate` - you can authenticate card.
- `transaction/bill` - you can withdraw money from authenticated card.

## Misc
There was an attemt to implement [Clean Architecture](https://blog.8thlight.com/uncle-bob/2012/08/13/the-clean-architecture.html). The vital parts of aplication are unit tested.
