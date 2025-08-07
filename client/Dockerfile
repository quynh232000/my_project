FROM node:20-alpine

WORKDIR /app

# Copy package files
COPY package.json package-lock.json ./

# Cài dependencies
RUN npm install --legacy-peer-deps

# Copy toàn bộ mã nguồn
COPY . .

# Build app
RUN npm run build

# Set env và cổng
ENV NODE_ENV=production
EXPOSE 3000

# Khởi động app
CMD ["npm", "start"]
# # Stage 1: Build
# FROM node:20-alpine AS builder

# WORKDIR /app

# COPY package*.json ./
# RUN npm ci --legacy-peer-deps

# COPY . .
# RUN npm run build

# # Stage 2: Production
# FROM node:20-alpine AS runner

# WORKDIR /app

# ENV NODE_ENV=production

# # Copy chỉ các file cần thiết
# COPY --from=builder /app/package*.json ./
# COPY --from=builder /app/node_modules ./node_modules
# COPY --from=builder /app/.next ./.next
# COPY --from=builder /app/public ./public
# COPY --from=builder /app/next.config.js ./

# EXPOSE 3000
# CMD ["npm", "start"]
