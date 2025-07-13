# Base image
FROM node:22-alpine AS base

# Dependencies stage
FROM base AS deps
RUN apk add --no-cache libc6-compat

WORKDIR /app

# Enable Yarn 4
RUN corepack enable && corepack prepare yarn@stable --activate

# Copy lockfile and package manifest
COPY package.json yarn.lock* ./

# Optional: Switch to PnP linker (saves RAM); comment if you rely on node_modules
RUN yarn config set nodeLinker pnp

# Install deps with low-RAM-friendly flags
RUN yarn install --immutable --check-cache --inline-builds

# Builder stage
FROM base AS builder
WORKDIR /app

# Enable Yarn again
RUN corepack enable && corepack prepare yarn@stable --activate

# Copy deps
COPY --from=deps /app /app

# Copy source
COPY . .

# Disable Next.js telemetry
ENV NEXT_TELEMETRY_DISABLED 1

# Build app
RUN yarn build

# Production image
FROM base AS runner
WORKDIR /app

RUN addgroup --system --gid 1001 nodejs
RUN adduser --system --uid 1001 nextjs

# Copy static assets and build output
COPY --from=builder /app/public ./public
RUN mkdir .next && chown nextjs:nodejs .next

# Copy standalone output
COPY --from=builder --chown=nextjs:nodejs /app/.next/standalone ./
COPY --from=builder --chown=nextjs:nodejs /app/.next/static ./.next/static

# Use non-root user
USER nextjs

EXPOSE 3000
ENV PORT 3000
ENV HOSTNAME "0.0.0.0"

# Start server
CMD ["node", "server.js"]
