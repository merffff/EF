<?php

class BankAccount
{
    private int $balance;

    public function __construct(int $balance)
    {
        $this->balance = $balance;
    }

    public function setBalance(int $balance)
    {
        $this->balance = $balance;
    }

    public function getBalance():int
    {
        return $this->balance;
    }

    public function deposit(int $deposit):int
    {
        $this->balance = $this->getBalance()+$deposit;
        return $this->balance;
    }

    public function withdraw(int $withdraw)
    {
        if ($withdraw < $this->balance) {
            return $this->balance = $this->balance-$withdraw;
        } else {
            echo "Ошибка: недостаточно средств";
        }
    }
}


$account = new BankAccount(1000);
$account->deposit(500);
echo $account->getBalance()."\n";


$account->withdraw(300);
echo $account->getBalance()."\n";


$account->withdraw(5000);


