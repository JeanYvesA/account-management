<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankAccountController extends Controller
{
    public function index(){
        
         $bankAccounts=BankAccount::where('user_id',Auth()->user()->id)->get();

         return view("bank_accounts.index", compact('bankAccounts'));
    }

    public function all(){
        
        $bankAccounts=BankAccount::all();

        return view("bank_accounts.index", compact('bankAccounts', 'page'));
   }

    public function create(){
       
        $permissions=Permission::all();

        return view("bank_accounts.create",compact('permissions'));
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            "name" => 'required',
            "firstname" => 'required',
        ]);

        //Permet de créer un numéro unique pour chaque compte
        do {
            $number='BJ0002'.mt_rand(100000, 999999);
            $findBank=BankAccount::where('number',$number)->first();
        } while ($findBank!=null);
        $bankAccount = BankAccount::create([
            'name' => $request->name,
            'firstname' => $request->firstname,
            'balance' => 0,
            'statut' => true,
            'number' => $number,
            'user_id' => Auth()->user()->id,
        ]);
        return redirect()->route('account')->with('success', 'Compte ajouté avec succès.');
    }

    public function Deposit(Request $request)
    {
        $validated = $request->validate([
            "amount" => 'required',
        ]);

        $currentAccount=BankAccount::find($request->id);
        if ($currentAccount && $currentAccount->statut) {

        //Les deux opérations sont mises dans une transaction
        DB::transaction(function () use (&$currentAccount, &$request) {
            //Ajout du montant
            $currentAccount->update(['balance'=>$currentAccount->balance+$request->amount]);
            //Création de la transaction
            Transaction::create([
                'type' => "DEPOSIT",
                'amount' => $request->amount,
                'bank_account_id' => $request->id,
            ]);
        });
            

            return redirect()->route('account')->with('success', 'Dépot effectué avec succès.');
        }
        else {
            return redirect()->route('account')->with('error', 'Impossible de faire le dépot. Le compte est désactivé ou innexistant.');
        }
    }

    public function Withdrawal(Request $request)
    {
        dd($request->all());
        $validated = $request->validate([
            "name" => 'required',
            "firstname" => 'required',
        ]);

        //Permet de créer un numéro unique pour chaque compte
        do {
            $number='BJ0002'.mt_rand(100000, 999999);
            $findBank=BankAccount::where('number',$number)->first();
        } while ($findBank!=null);
        $bankAccount = BankAccount::create([
            'name' => $request->name,
            'firstname' => $request->firstname,
            'balance' => 0,
            'statut' => true,
            'number' => $number,
            'user_id' => Auth()->user()->id,
        ]);
        return redirect()->route('account')->with('success', 'Compte ajouté avec succès.');
    }
}
