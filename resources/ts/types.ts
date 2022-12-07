export type TransactionType = 'in' | 'out';

export type Transaction = {
    id: number;
    segment_id: number;
    group_id: string;
    segment_name: string;
    description: string;
    type: TransactionType;
    amount: string;
    pending: boolean;
    valid_at: string;
    created_at: string;
}

export type Segment = {
    id: number;
    name: string;
    active: boolean;
}

export type Balance = {
    segment_name: string;
    amount: string;
}

export type FlashMessageLevel = 'success' | 'warning' | 'error';

export type FlashMessage = {
    id: string;
    level: FlashMessageLevel,
    content: string;
}