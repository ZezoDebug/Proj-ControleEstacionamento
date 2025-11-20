# Frontend do Sistema de Controle de Estacionamento

## Visão Geral
Este é um frontend interativo e moderno para o sistema de controle de estacionamento, desenvolvido com tecnologias atuais seguindo padrões de clean code e princípios SOLID.

## Tecnologias Utilizadas
- **HTML5** - Estrutura da aplicação
- **Tailwind CSS** - Framework CSS para estilização moderna
- **JavaScript ES6+** - Lógica da aplicação com classes modulares
- **SweetAlert2** - Alertas e modais elegantes
- **ApexCharts** - Gráficos interativos para relatórios
- **Font Awesome** - Ícones vetoriais

## Estrutura do Projeto
```
public/frontend/
├── index.html          # Página principal
├── js/
│   └── app.js         # Lógica da aplicação (modular)
└── css/
    └── styles.css     # Estilos customizados e animações
```

## Funcionalidades
- ✅ **Registro de Entrada**: Formulário para registrar entrada de veículos
- ✅ **Registro de Saída**: Cálculo automático de preço e saída de veículos
- ✅ **Lista de Veículos Estacionados**: Visualização em tempo real
- ✅ **Relatórios**: Gráficos de faturamento por tipo de veículo
- ✅ **Interface Responsiva**: Funciona em desktop e mobile
- ✅ **Animações**: Transições suaves e loading states
- ✅ **Feedback Visual**: SweetAlerts para sucesso/erro

## Princípios SOLID Implementados
- **Single Responsibility**: Classes APIService e UIManager têm responsabilidades únicas
- **Open/Closed**: Código extensível sem modificar classes existentes
- **Liskov Substitution**: Interfaces consistentes
- **Interface Segregation**: Métodos específicos por classe
- **Dependency Inversion**: Injeção de dependências

## Como Usar
1. Certifique-se de que o backend PHP está rodando (XAMPP ou similar)
2. Acesse `http://localhost/Proj-ControleEstacionamento/public/frontend/`
3. Use o dashboard para registrar entradas e saídas
4. Visualize relatórios clicando na aba "Relatórios"

## APIs Utilizadas
- `POST /api/entry.php` - Registrar entrada
- `GET /api/parked.php` - Listar veículos estacionados
- `POST /api/exit.php` - Registrar saída e calcular preço
- `GET /api/reports.php` - Obter dados para relatórios

## Design Moderno
- Paleta de cores profissional (azul, verde, vermelho)
- Tipografia clara e hierárquica
- Cards com sombras e hover effects
- Botões com feedback visual
- Loading spinners durante operações
- Animações de fade-in para novos elementos

## Responsividade
- Layout adaptável para diferentes tamanhos de tela
- Navegação otimizada para mobile
- Formulários touch-friendly