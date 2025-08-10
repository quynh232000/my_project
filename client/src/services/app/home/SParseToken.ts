export async function SParseToken(token: any) {
    const res = await fetch('/api/parse-token', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ token })
    });
    return res.json();
}
