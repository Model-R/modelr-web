#############################
####    Script modelR   ####
############################

# Carregando pacotes
require(modelr)
require(raster)

args <- commandArgs(TRUE)     
id <- args[1]  
rasterCSVPath <- args[2]  
ocorrenciasCSVPath <- args[3]
extensionPath <- args[4]
coordenadas <- read.table(ocorrenciasCSVPath, sep = ';', h = T);
especies <- unique(coordenadas$taxon);

if(getwd() == "/var/www/html/rafael/modelr/v2" || getwd() == "/var/www/html/rafael/modelr/v3"){
	cat('v2')
	baseUrl <- '../'
} else {
	cat('main')
	baseUrl <- ''
}

rasters <- read.table(rasterCSVPath, sep = ';', header = F, as.is = T);
#rasters
rasters <- paste0(baseUrl,'../../../../../',rasters)
stack_rasters <- stack(rasters)

data_json = geojsonio::geojson_read(extensionPath, what = "sp")
stack_rasters <- mask(crop(stack_rasters, data_json), data_json)
#stack_rasters

##-----------------------------------------------##
# vamos receber v�rias variaveis: ocorrencias.csv, raster.csv, partitions, buffer, num_points, tss, hash id
# criar variaveis_preditoras a partir de raster.csv
##-----------------------------------------------##

resultFolder <- 'temp/result/'
#Cria diret�rio onde ser�o salvos os resultados
#dir.create(paste0(resultFolder, hashId));

clean = function(coord, abio) {
    if (dim(coord)[2] == 2) {
        if (exists("abio")) {
            # selecionar os pontos únicos e sem NA
            mask = abio[[1]]
            # Selecionar pontos espacialmente únicos #
            cell <- cellFromXY(mask, coord)  # get the cell number for each point
            dup <- duplicated(cell)
            pts1 <- coord[!dup, ]  # select the records that are not duplicated
            pts1 <- pts1[!is.na(extract(mask, pts1)), ]  #selecionando apenas pontos que tem valor de raster
			
			cat(dim(coord)[1] - dim(pts1)[1], "points removed\n")
            cat(dim(pts1)[1], "spatially unique points\n")
            names(pts1) <- c("lon", "lat")#
			return(dim(pts1)[1])
        } else (cat("Indicate the object with the predictive variables"))
    } else (stop("Coordinate table has more than two columns.\nThis table should only have longitude and latitude in this order."))
}

reg.clean=c()
for(especie in especies) {
  sp.clean = clean(coordenadas[coordenadas[, "taxon"] == especie, c("lon","lat")], stack_rasters[[1]])
  sp.clean = as.array(sp.clean)
  sp.clean$sp=especie
  reg.clean = rbind(reg.clean,sp.clean)
}

reg.clean