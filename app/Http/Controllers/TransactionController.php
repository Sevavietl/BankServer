<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use BankServer\Domain\Service\ConductTransactionService;
use BankServer\Domain\Repository\TransactionRepositoryInterface;

class TransactionController extends Controller
{
    protected $transactionService;
    protected $repository;

    public function __construct(
        ConductTransactionService $transactionService,
        TransactionRepositoryInterface $repository
    ){
        $this->transactionService = $transactionService;
        $this->repository = $repository;

        $this->middleware('menu', ['only' => 'index']);
    }

    public function index()
    {
        $transactions = $this->repository->getAll();

        return view('transaction.index')->with(compact('transactions'));
    }

    public function authenticate(Request $request)
	{
       $firstName = $request->get('first_name');
       $lastName = $request->get('last_name');
       $cardNumber = $request->get('card_number');
       $cardExpiration = $request->get('card_expiration');

       if (!$this->transactionService->authenticate($firstName, $lastName, $cardNumber, $cardExpiration)) {
            return response()->json([
                'authenticated' => false,
                'error' => $this->transactionService->getLastError()
            ]);
       }

       return response()->json([
           'authenticated' => true,
           'token' => $this->transactionService->getToken(),
       ]);
	}

	public function bill(Request $request)
	{
        $token = $request->get('token');
        $amount = $request->get('amount');

        if (!$this->transactionService->bill($token, $amount)) {
             return response()->json([
                 'billed' => false,
                 'error' => $this->transactionService->getLastError()
             ]);
        }

        return response()->json([
            'billed' => true,
        ]);
	}
}
