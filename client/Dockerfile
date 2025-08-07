# FROM node:20-alpine

# WORKDIR /app

# # Copy package files
# COPY package.json package-lock.json ./

# # Cài dependencies
# RUN npm install --legacy-peer-deps

# # Copy toàn bộ mã nguồn
# COPY . .

# # Build app
# RUN npm run build

# # Set env và cổng
# ENV NODE_ENV=production
# EXPOSE 3000

# # Khởi động app
# CMD ["npm", "start"]

# Stage 1: Build app
FROM node:20-alpine AS builder

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci --legacy-peer-deps

COPY . .
RUN npm run build

# Stage 2: Run production server
FROM node:20-alpine AS runner

WORKDIR /app

ENV NODE_ENV=production

COPY --from=builder /app/.next .next
COPY --from=builder /app/public ./public
COPY --from=builder /app/package.json ./

# Cài dependencies production (bằng npm)
RUN npm install --omit=dev --legacy-peer-deps

EXPOSE 3000

CMD ["npx", "next", "start"]

