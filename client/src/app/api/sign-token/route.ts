import { NextResponse } from "next/server";
import jwt from "jsonwebtoken";
import { JWT_SECRET } from "@/services/type";

const SECRET = JWT_SECRET;

export async function POST(req: Request) {
    const body = await req.json();

    const payload = {
        info: {
            room_id: body.room_id,
            price_type_id: body.price_type_id,
            date_start: body.date_start,
            date_end: body.date_end,
            adt: body.adt,
            quantity: body.quantity,
        },
        sub: body.room_id, // bắt buộc nếu tymon/jwt-auth cần
        iat: Math.floor(Date.now() / 1000),
    };

    const token = jwt.sign(payload, SECRET, { expiresIn: "15m", algorithm: "HS256" });

    return NextResponse.json({ token, serect: SECRET });
}