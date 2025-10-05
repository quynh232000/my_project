export const formatDate = (timestamp: string | number | Date) => {
    const date = new Date(timestamp);
    return new Intl.DateTimeFormat('vi-VN', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
    }).format(date);
};