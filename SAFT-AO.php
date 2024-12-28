<?php

use Spatie\ArrayToXml\ArrayToXml;

class Saft{
    public function gerarSaft()
    {
        // Dados do cabeçalho
        $header = [
            'CompanyName' => 'Nome da Empresa',
            'TaxRegistrationNumber' => '123456789',
            'TaxAccountingBasis' => 'Faturamento',
            'CompanyAddress' => [
                'AddressDetail' => 'Rua Principal, 123',
                'City' => 'Luanda',
                'Country' => 'AO',
            ],
            'FiscalYear' => '2024',
            'StartDate' => '2024-01-01',
            'EndDate' => '2024-12-31',
        ];

        // Dados dos clientes
        $customers = [
            [
                'CustomerID' => 'C001',
                'CustomerTaxID' => '987654321',
                'CompanyName' => 'Cliente 1',
                'BillingAddress' => [
                    'AddressDetail' => 'Rua Cliente, 45',
                    'City' => 'Luanda',
                    'Country' => 'AO',
                ],
            ],
            [
                'CustomerID' => 'C002',
                'CustomerTaxID' => '123123123',
                'CompanyName' => 'Cliente 2',
                'BillingAddress' => [
                    'AddressDetail' => 'Av. Liberdade, 89',
                    'City' => 'Benguela',
                    'Country' => 'AO',
                ],
            ],
        ];

        // Dados das faturas
        $invoices = [
            [
                'InvoiceNo' => 'FT001',
                'InvoiceDate' => '2024-12-01',
                'CustomerID' => 'C001',
                'Lines' => [
                    'Line' => [
                        'ProductCode' => 'P001',
                        'ProductDescription' => 'Produto 1',
                        'Quantity' => 2,
                        'UnitPrice' => 500,
                        'CreditAmount' => 1000,
                        'Tax' => [
                            'TaxType' => 'IVA',
                            'TaxPercentage' => 14,
                        ],
                    ],
                ],
                'DocumentTotals' => [
                    'TaxPayable' => 140,
                    'NetTotal' => 1000,
                    'GrossTotal' => 1140,
                ],
            ],
        ];

        // Estrutura do XML
        $data = [
            'Header' => $header,
            'MasterFiles' => [
                'Customer' => $customers,
            ],
            'SourceDocuments' => [
                'SalesInvoices' => [
                    'Invoice' => $invoices,
                ],
            ],
        ];

        // Gerar XML
        $xml = ArrayToXml::convert($data, [
            'rootElementName' => 'AuditFile',
            '_attributes' => [
                'xmlns' => 'urn:OECD:StandardAuditFile-Tax:AO',
            ],
        ]);

        // Salvar arquivo
        $filePath = storage_path('saft_ao.xml');
        file_put_contents($filePath, $xml);

        return response()->download($filePath);
    }
}
