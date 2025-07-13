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
