yellow='\033[1;33m'
green='\033[1;32m'

yellowOutput () {
printf "${yellow}$1\n"
}

greenOutput () {
printf "${green}$1\n"
}

yellowOutput "=== Starting Containers... ==="
docker compose up -d
greenOutput "Containers started."

# ======================================================================================================================

yellowOutput "=== Starting Email Service Setup ==="

yellowOutput "Verifying .env..."
if ! [ -f ./email-service/.env ]; then
  cp ./email-service/.env.example ./email-service/.env
  greenOutput ".env created."
fi

yellowOutput "Installing dependencies..."
docker compose exec email_service composer install --ignore-platform-reqs
greenOutput "Dependencies ok."

yellowOutput "Running migrations..."
docker compose exec email_service php artisan migrate
greenOutput "Migrations ok."

greenOutput "Email Service configured successfully."

# ======================================================================================================================

yellowOutput "=== Starting Transcription Service Setup... ==="

yellowOutput "Verifying .env..."
if ! [ -f ./transcription-service/.env ]; then
  cp ./transcription-service/.env.example ./transcription-service/.env
  greenOutput ".env created."
fi

yellowOutput "Installing dependencies..."
docker compose exec transcription_service composer install --ignore-platform-reqs
greenOutput "Dependencies ok."

yellowOutput "Running migrations..."
docker compose exec transcription_service php artisan migrate
greenOutput "Migrations ok."

greenOutput "Transcription Service configured successfully."

# ======================================================================================================================

yellowOutput "=== Starting Upload Service Setup... ==="

yellowOutput "Verifying .env..."
if ! [ -f ./upload-service/.env ]; then
  cp ./upload-service/.env.example ./upload-service/.env
  greenOutput ".env created."
fi

yellowOutput "Installing dependencies..."
docker compose exec upload_service composer install --ignore-platform-reqs
greenOutput "Dependencies ok."

yellowOutput "Running migrations..."
docker compose exec upload_service php artisan migrate
greenOutput "Migrations ok."

greenOutput "Upload Service configured successfully."

# ======================================================================================================================
