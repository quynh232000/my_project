# Stage 1: Build app
FROM node:20-alpine AS builder

WORKDIR /app

# Copy package files
COPY package.json package-lock.json ./

# Cài đặt dependencies, bỏ qua lỗi peer deps
RUN npm install --legacy-peer-deps

# Copy source code
COPY . .

# Build app
RUN npm run build

# Stage 2: Run app
FROM node:20-alpine AS runner

WORKDIR /app

COPY --from=builder /app ./

ENV NODE_ENV=production

EXPOSE 3000

CMD ["npm", "start"]
