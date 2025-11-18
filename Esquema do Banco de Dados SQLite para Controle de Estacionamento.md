# Esquema do Banco de Dados SQLite para Controle de Estacionamento

Com base na entidade `ParkingEntry`, a tabela principal para persistir as entradas de veículos no estacionamento será `parking_entries`.

## Tabela `parking_entries`

Esta tabela armazenará os registros de entrada dos veículos.

| Coluna | Tipo de Dado (SQLite) | Restrições | Descrição |
| :--- | :--- | :--- | :--- |
| `id` | `INTEGER` | `PRIMARY KEY AUTOINCREMENT` | Identificador único do registro. |
| `plate` | `TEXT` | `NOT NULL` | A placa do veículo (ex: "ABC1234"). |
| `vehicle_type` | `TEXT` | `NOT NULL` | O tipo de veículo (ex: "CAR", "MOTO", "TRUCK"). |
| `entry_time` | `TEXT` | `NOT NULL` | O timestamp da entrada, armazenado como texto no formato ISO 8601 (ex: "YYYY-MM-DD HH:MM:SS"). |

## SQL para Criação da Tabela

```sql
CREATE TABLE IF NOT EXISTS parking_entries (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    plate TEXT NOT NULL,
    vehicle_type TEXT NOT NULL,
    entry_time TEXT NOT NULL
);
```

## Considerações Adicionais

*   **Tipos de Dados:** O SQLite é flexível. Para datas e horas, o tipo `TEXT` no formato ISO 8601 é a forma recomendada para garantir a compatibilidade e facilidade de ordenação.
*   **Chave Primária:** A coluna `id` é essencial para identificar unicamente cada registro, o que será útil para futuras operações como a saída do veículo.
*   **Valores de `vehicle_type`:** Os valores inseridos nesta coluna devem corresponder aos tipos definidos no seu `VehicleType` (provavelmente 'CAR', 'MOTO', 'TRUCK').
