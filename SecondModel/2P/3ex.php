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

class CreditAccount extends BankAccount
{
    public function __construct(int $balance)
    {
        parent::__construct($balance);
    }

    public function withdraw(int $withdraw):void
    {
        $this->setBalance($this->getBalance()-$withdraw);
        echo $this->getBalance(). " (допустимый минус)";

    }

}

$credit = new CreditAccount(1000);
$credit->withdraw(1500);


