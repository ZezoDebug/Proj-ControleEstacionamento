const API_BASE = '../api/';


const showLoading = (element, text = 'Carregando...') => {
    element.innerHTML = `<div class="flex items-center justify-center py-4"><i class="fas fa-spinner fa-spin mr-2"></i>${text}</div>`;
};

const showError = (message) => {
    Swal.fire({
        icon: 'error',
        title: 'Erro',
        text: message,
        confirmButtonColor: '#ef4444'
    });
};

const showSuccess = (message) => {
    Swal.fire({
        icon: 'success',
        title: 'Sucesso',
        text: message,
        confirmButtonColor: '#10b981',
        timer: 2000,
        showConfirmButton: false
    });
};

class APIService {
    async request(endpoint, options = {}) {
        try {
            const response = await fetch(`${API_BASE}${endpoint}`, {
                headers: {
                    'Content-Type': 'application/json',
                    ...options.headers
                },
                ...options
            });

            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.error || 'Erro na requisição');
            }

            return await response.json();
        } catch (error) {
            console.error('API Error:', error);
            throw error;
        }
    }

    async registerEntry(plate, vehicleType) {
        return this.request('entry.php', {
            method: 'POST',
            body: JSON.stringify({ plate, vehicleType })
        });
    }

    async getParkedVehicles() {
        return this.request('parked.php');
    }

    async exitVehicle(plate) {
        return this.request('exit.php', {
            method: 'POST',
            body: JSON.stringify({ plate })
        });
    }

    async getReports() {
        return this.request('reports.php');
    }
}

class UIManager {
    constructor(apiService) {
        this.api = apiService;
        this.init();
    }

    init() {
        this.bindEvents();
        this.loadParkedVehicles();
    }

    bindEvents() {
        document.getElementById('dashboardBtn').addEventListener('click', () => this.showSection('dashboard'));
        document.getElementById('reportsBtn').addEventListener('click', () => this.showSection('reports'));

        document.getElementById('entryForm').addEventListener('submit', (e) => this.handleEntry(e));
        document.getElementById('exitForm').addEventListener('submit', (e) => this.handleExit(e));
    }

    showSection(section) {
        document.getElementById('dashboard').classList.toggle('hidden', section !== 'dashboard');
        document.getElementById('reports').classList.toggle('hidden', section !== 'reports');

        if (section === 'reports') {
            this.loadReports();
        }
    }

    async handleEntry(e) {
        e.preventDefault();
        const plate = document.getElementById('plate').value.toUpperCase();
        const vehicleType = document.getElementById('vehicleType').value;

        try {
            await this.api.registerEntry(plate, vehicleType);
            showSuccess('Veículo registrado com sucesso!');
            e.target.reset();
            this.loadParkedVehicles();
        } catch (error) {
            showError(error.message);
        }
    }

    async handleExit(e) {
        e.preventDefault();
        const plate = document.getElementById('exitPlate').value.toUpperCase();

        try {
            const result = await this.api.exitVehicle(plate);
            Swal.fire({
                icon: 'success',
                title: 'Saída Registrada',
                html: `
                    <p>Veículo: <strong>${result.vehicleType}</strong></p>
                    <p>Valor a pagar: <strong>R$ ${result.price.toFixed(2)}</strong></p>
                `,
                confirmButtonColor: '#10b981'
            });
            e.target.reset();
            this.loadParkedVehicles();
        } catch (error) {
            showError(error.message);
        }
    }

    async loadParkedVehicles() {
        const container = document.getElementById('parkedVehicles');
        showLoading(container, 'Carregando veículos...');

        try {
            const data = await this.api.getParkedVehicles();
            this.renderParkedVehicles(data.parked);
        } catch (error) {
            container.innerHTML = '<p class="text-red-500">Erro ao carregar veículos</p>';
            showError(error.message);
        }
    }

    renderParkedVehicles(vehicles) {
        const container = document.getElementById('parkedVehicles');

        if (vehicles.length === 0) {
            container.innerHTML = '<p class="text-gray-500 text-center py-4">Nenhum veículo estacionado</p>';
            return;
        }

        container.innerHTML = vehicles.map(vehicle => `
            <div class="flex justify-between items-center bg-gray-50 p-3 rounded-md animate-fade-in">
                <div>
                    <span class="font-medium">${vehicle.plate}</span>
                    <span class="text-sm text-gray-600 ml-2">(${vehicle.vehicleType})</span>
                </div>
                <div class="text-sm text-gray-500">
                    Entrada: ${new Date(vehicle.entryTime).toLocaleString('pt-BR')}
                </div>
            </div>
        `).join('');
    }

    async loadReports() {
        const container = document.getElementById('chartContainer');
        showLoading(container, 'Carregando relatórios...');

        try {
            const data = await this.api.getReports();
            this.renderChart(data.reports);
        } catch (error) {
            container.innerHTML = '<p class="text-red-500">Erro ao carregar relatórios</p>';
            showError(error.message);
        }
    }

    renderChart(reports) {
        const container = document.getElementById('chartContainer');
        container.innerHTML = '<div id="chart"></div>';

        const options = {
            series: [{
                name: 'Faturamento (R$)',
                data: [reports.carro.revenue, reports.moto.revenue, reports.caminhao.revenue]
            }, {
                name: 'Quantidade',
                data: [reports.carro.count, reports.moto.count, reports.caminhao.count]
            }],
            chart: {
                type: 'bar',
                height: 400,
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 1000
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Carros', 'Motos', 'Caminhões']
            },
            yaxis: {
                title: {
                    text: 'Valores'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val % 1 === 0 ? val : 'R$ ' + val.toFixed(2);
                    }
                }
            }
        };

        const chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const apiService = new APIService();
    new UIManager(apiService);
});