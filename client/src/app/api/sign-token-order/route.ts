import { NextResponse } from "next/server";
import jwt from "jsonwebtoken";
import { JWT_SECRET } from "@/services/type";

const SECRET = JWT_SECRET;

export async function POST(req: Request) {
    const body = await req.json();

    const payload = {
        ...body,
        sub: body.hotel_id ?? 1, // bắt buộc nếu tymon/jwt-auth cần
        iat: Math.floor(Date.now() / 1000),
    };

    const token = jwt.sign(payload, SECRET, { expiresIn: "15m", algorithm: "HS256" });

    return NextResponse.json({ token, serect: SECRET });
}