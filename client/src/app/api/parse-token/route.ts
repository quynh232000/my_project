import { NextResponse } from "next/server";
import jwt from "jsonwebtoken";
import { JWT_SECRET } from "@/services/type";

const SECRET = JWT_SECRET;

export async function POST(req: Request) {
    try {
        const { token } = await req.json();
        if (!token) {
            return NextResponse.json({ error: "Token is required" }, { status: 400 });
        }

        // Giải mã + kiểm tra thời gian
        const decoded = jwt.verify(token, SECRET) as any; // chỉ chạy nếu token hợp lệ

        const now = Math.floor(Date.now() / 1000);
        const exp = decoded.exp; // exp là timestamp (seconds)
        const timeLeft = exp - now;

        return NextResponse.json({
            valid: true,
            payload: decoded,
            timeLeft: timeLeft > 0 ? timeLeft : 0
        });
    } catch (err: any) {
        return NextResponse.json(
            { valid: false, error: err.name, message: err.message },
            { status: 401 }
        );
    }
}
