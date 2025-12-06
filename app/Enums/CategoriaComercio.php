<?php

namespace App\Enums;

enum CategoriaComercio: int
{
    case ALIMENTACAO = 1;
    case ROUPAS_ACESSORIOS = 2;
    case ELETRONICOS = 3;
    case BELEZA_SAUDE = 4;
    case SUPERMERCADO = 5;
    case SERVICOS = 6;
    case EDUCACAO = 7;
    case ENTRETENIMENTO = 8;

    public function label(): string
    {
        return match ($this) {
            self::ALIMENTACAO => 'Alimentação',
            self::ROUPAS_ACESSORIOS => 'Roupas e Acessórios',
            self::ELETRONICOS => 'Eletrônicos',
            self::BELEZA_SAUDE => 'Beleza e Saúde',
            self::SUPERMERCADO => 'Supermercado',
            self::SERVICOS => 'Serviços',
            self::EDUCACAO => 'Educação',
            self::ENTRETENIMENTO => 'Entretenimento',
        };
    }
}
