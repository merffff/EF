<?php


interface Payable
{
    public function pay (int $amount):void;
}

class BankAccount implements Payable
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

    public function pay(int $amount):void
    {
        if ($amount< $this->balance){
            $this->balance = $this->balance - $amount;
            echo "Баланс уменьшился на $amount \n";
        } else {
            echo "Операция отклонена: недостаточно средств \n";
        }
    }
}

class CreditAccount extends BankAccount implements Payable
{
    public function __construct(int $balance)
    {
        parent::__construct($balance);
    }

    public function withdraw(int $withdraw)
    {
        $this->setBalance($this->getBalance()-$withdraw);
        echo $this->getBalance(). " (допустимый минус)";

    }

    public function pay(int $amount):void
    {
        $this->setBalance($this->getBalance()-$amount);
        if ($this->getBalance() < 0) {
            echo "Баланс ушел в ". $this->getBalance(). "(кредитный лимит) \n";
        } else {
            echo "Баланс уменьшился на $amount \n";
        }

    }

}


$bank = new BankAccount(500);
$credit = new CreditAccount(500);

$bank->pay(200);
// ✅ Баланс уменьшился на 200

$credit->pay(700);
// ✅ Баланс ушел в -200 (кредитный лимит)

