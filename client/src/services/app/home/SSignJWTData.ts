export async function signJWTData(data: any) {
    const res = await fetch('/api/sign-token', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    });
    const json = await res.json();
    return json.token;
}
