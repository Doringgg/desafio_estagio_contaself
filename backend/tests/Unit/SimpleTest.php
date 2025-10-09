<?php
require_once __DIR__ . '/../../src/utils/HttpResponse.php';
require_once __DIR__ . '/../../src/DAO/CursosDAO.php';
require_once __DIR__ . '/../../src/middleware/AlunosMiddleware.php';

echo "🧪 TESTE MANUAL DO ALUNOS MIDDLEWARE\n";

$middleware = new AlunosMiddleware();

// Teste 1
$result1 = $middleware->isValidNomeAluno('joão silva');
echo "Teste 1 - 'joão silva': " . ($result1 === 'João Silva' ? '✅ PASSOU' : '❌ FALHOU') . "\n";

// Teste 2  
$result2 = $middleware->isValidNomeAluno('MARIA COSTA');
echo "Teste 2 - 'MARIA COSTA': " . ($result2 === 'Maria Costa' ? '✅ PASSOU' : '❌ FALHOU') . "\n";

// Teste 3
$result3 = $middleware->isValidNomeAluno('  carlos eduardo  ');
echo "Teste 3 - '  carlos eduardo  ': " . ($result3 === 'Carlos Eduardo' ? '✅ PASSOU' : '❌ FALHOU') . "\n";

echo "\n🎯 RESULTADO: ";
if ($result1 === 'João Silva' && $result2 === 'Maria Costa' && $result3 === 'Carlos Eduardo') {
    echo "TODOS OS TESTES PASSARAM! 🎉";
} else {
    echo "ALGUNS TESTES FALHARAM! 🔧";
}

//PARA EXECUTÁ-LO EXECUTE O COMANDO ABAIXO NO TERMINAL

// cd C:\xampp\htdocs\desafio_estagio_contaself
//php backend\tests\Unit\SimpleTest.php