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
FROM node:22-alpine AS base

# Install dependencies only when needed
# FROM base AS deps
# # Check https://github.com/nodejs/docker-node/tree/b4117f9333da4138b03a546ec926ef50a31506c3#nodealpine to understand why libc6-compat might be needed.
# RUN apk add --no-cache libc6-compat
# WORKDIR /app

# # Install Yarn
# RUN corepack enable && corepack prepare yarn@stable --activate

# # Install dependencies based on the preferred package manager
# COPY package.json yarn.lock* ./

# RUN yarn config set nodeLinker node-modules

# # RUN yarn install --immutable
# # RUN yarn install --frozen-lockfile
# RUN yarn install

# # Rebuild the source code only when needed
# FROM base AS builder
# WORKDIR /app

# # Install Yarn in this stage as well
# RUN corepack enable && corepack prepare yarn@stable --activate

# COPY --from=deps /app/node_modules ./node_modules
# COPY --from=deps /app/yarn.lock ./yarn.lock
# COPY . .

# # Next.js collects completely anonymous telemetry data about general usage.
# # Learn more here: https://nextjs.org/telemetry
# # Uncomment the following line in case you want to disable telemetry during the build.
# # ENV NEXT_TELEMETRY_DISABLED 1

# RUN yarn build

# # Production image, copy all the files and run next
# FROM base AS runner
# WORKDIR /app

# # ENV NODE_ENV production
# # Uncomment the following line in case you want to disable telemetry during runtime.
# # ENV NEXT_TELEMETRY_DISABLED 1

# RUN addgroup --system --gid 1001 nodejs
# RUN adduser --system --uid 1001 nextjs

# COPY --from=builder /app/public ./public

# # Set the correct permission for prerender cache
# RUN mkdir .next
# RUN chown nextjs:nodejs .next

# # Automatically leverage output traces to reduce image size
# # https://nextjs.org/docs/advanced-features/output-file-tracing
# COPY --from=builder --chown=nextjs:nodejs /app/.next/standalone ./
# COPY --from=builder --chown=nextjs:nodejs /app/.next/static ./.next/static

# USER nextjs

# EXPOSE 3000

# ENV PORT 3000
# ENV HOSTNAME "0.0.0.0"

# # server.js is created by next build from the standalone output
# # https://nextjs.org/docs/pages/api-reference/next-config-js/output
# CMD ["node", "server.js"]
# Base image with Node.js 22 on Alpine Linux
FROM node:22-alpine AS base

# --------------------------------------------------------------------------------
# Stage: Dependencies
# --------------------------------------------------------------------------------
FROM base AS deps

# Needed for some native dependencies (e.g., WebAssembly)
RUN apk add --no-cache libc6-compat

WORKDIR /app

# Enable Yarn (via Corepack)
RUN corepack enable && corepack prepare yarn@stable --activate

# Copy lock files and package manifest
COPY package.json yarn.lock* ./

# Use node_modules linker instead of PnP (optional but recommended for Next.js)
RUN yarn config set nodeLinker node-modules

# Install dependencies
RUN yarn install --immutable

# --------------------------------------------------------------------------------
# Stage: Builder
# --------------------------------------------------------------------------------
FROM base AS builder

WORKDIR /app

# Enable Yarn again in this stage
RUN corepack enable && corepack prepare yarn@stable --activate

# Copy dependencies and lock file from previous stage
COPY --from=deps /app/node_modules ./node_modules
COPY --from=deps /app/yarn.lock ./yarn.lock

# Copy full source code
COPY . .

# Optional: Disable Next.js telemetry (uncomment if needed)
# ENV NEXT_TELEMETRY_DISABLED=1

# Build the app using Next.js
RUN yarn build

# --------------------------------------------------------------------------------
# Stage: Production Runner
# --------------------------------------------------------------------------------
FROM base AS runner

WORKDIR /app

# Set production environment
ENV NODE_ENV=production
ENV NEXT_TELEMETRY_DISABLED=1
ENV PORT=3000
ENV HOSTNAME="0.0.0.0"

# Create non-root user
RUN addgroup --system --gid 1001 nodejs \
  && adduser --system --uid 1001 nextjs

# Copy public assets
COPY --from=builder /app/public ./public

# Create and set permissions for .next
RUN mkdir .next && chown nextjs:nodejs .next

# Copy standalone Next.js build output
COPY --from=builder --chown=nextjs:nodejs /app/.next/standalone ./
COPY --from=builder --chown=nextjs:nodejs /app/.next/static ./.next/static

# Use non-root user for security
USER nextjs

# Expose the default Next.js port
EXPOSE 3000

# Start the server
CMD ["node", "server.js"]
