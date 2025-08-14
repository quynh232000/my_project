export async function signJWTData(data: any, type?: string) {
    const res = await fetch('/api/sign-token' + (type ? '-order' : ''), {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    });
    const json = await res.json();
    return json.token;
}
