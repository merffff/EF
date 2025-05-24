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


class SavingsAccount extends BankAccount
{
    private int $interestRate;

    public function __construct(int $balance, int $interestRate)
    {
        parent::__construct($balance);
        $this->interestRate=$interestRate;
    }

    public function applyInterest():void
    {
        $this->setBalance($this->getBalance()*(1+$this->interestRate/100));
    }

}

$savings = new SavingsAccount(1000, 5);
$savings->applyInterest();
echo $savings->getBalance();
