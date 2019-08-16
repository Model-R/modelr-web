#############################
####    Script modelR   ####
############################

# Carregando pacotes
require(ModelR)
require(raster)
require(vegan)
require(psych)

args <- commandArgs(TRUE)
id <- args[1]
ocorrenciasCSVPath <- args[2]

coordenadas <- read.table(ocorrenciasCSVPath, sep = ';', header = T);

coordinates(coordenadas) <- ~lon+lat
extent(coordenadas)
#extent(coordenadas)[1]
#paste0(extent(coordenadas)[1],';',extent(coordenadas)[2],';',extent(coordenadas)[3],';',extent(coordenadas)[4])