<?php

namespace linnoxlewis\iap\interfaces;

interface IapInterface
{
    /**
     * Метод верификации рецепта покупки.
     *
     * @param string $receipt закодированный рецепт поукпки.
     *
     * @throws \Exception
     * @return array
     */
    public function verify(string $receipt) : array;
}
