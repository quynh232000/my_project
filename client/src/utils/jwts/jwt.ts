import jwt from "jsonwebtoken";

const SECRET = "client_safe_secret";

export function signJWTData(
  data: Omit<any, "exp">,
  expiresInMinutes: number = 10
): string {
  return jwt.sign(data, SECRET, { expiresIn: `${expiresInMinutes}m` });
}

// export function decodeBookingData(token: string): any | null {
//   try {
//     const base64Url = token.split('.')[1];
//     const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
//     const jsonPayload = decodeURIComponent(
//       atob(base64)
//         .split('')
//         .map(c => '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2))
//         .join('')
//     );

//     const payload: any = JSON.parse(jsonPayload);
//     const now = Math.floor(Date.now() / 1000);

//     if (payload.exp && now > payload.exp) {
//       return null; // Token đã hết hạn
//     }

//     return payload;
//   } catch (err: any) {
//     console.log('====================================');
//     console.log(err);
//     console.log('====================================');
//     return null; // Token lỗi định dạng
//   }
// }