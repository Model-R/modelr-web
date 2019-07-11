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
hashId <- args[2]
repetitions <- args[3]
partitions <- args[4]
partitiontype <- args[5]
trainpercent <- args[6]
bufferValue <- args[7]
num_points <- args[8]
tss <- args[9]
rasterCSVPath <- args[10]
ocorrenciasCSVPath <- args[11]
algorithms <- args[12]
extensionPath <- args[13]
projectionPath <- args[14]

cat('antes')
if(bufferValue == 'NULL') bufferValue = NULL;
algorithms
#extensionPath <- paste0('../../../../../../','mnt/dados/modelr/json/polygon-317.json')

if(getwd() != "/var/www/html/rafael/modelr"){
	cat('v2')
	baseUrl <- '../'
} else {
	cat('main')
	baseUrl <- ''
}

coordenadas <- read.table(ocorrenciasCSVPath, sep = ';', header = T);
coordenadas
rasters <- read.table(rasterCSVPath, sep = ';', header = F, as.is = T);
rasters
#rasters <- read.file(rasterCSVPath, sep = ';', h = F)
#setwd('../../../../../')
#getwd()algorithmsArray[[1]] == TRUE
algorithmsArray <- as.list(strsplit(algorithms, ';')[[1]])
rasters <- paste0(baseUrl,'../../../../../',rasters)
stack_rasters <- stack(rasters)

proj_data_json = geojsonio::geojson_read(projectionPath, what = "sp")
data_json = geojsonio::geojson_read(extensionPath, what = "sp")
stack_rasters <- mask(crop(stack_rasters, data_json), data_json)

cat('extension')
data_json
cat('projection')
proj_data_json

especies <- unique(coordenadas$taxon);
##-----------------------------------------------##
# vamos receber várias variáveis: ocorrencias.csv, raster.csv, partitions, buffer, num_points, tss, hash id
# criar variaveis_preditoras a partir de raster.csv
##-----------------------------------------------##

resultFolder <- paste0(baseUrl,'temp/result/')
#Cria diretório onde serão salvos os resultados
#dir.create(paste0(resultFolder, hashId));

clean <- function(coord, abio) {
    if (dim(coord)[2] == 2) {
        if (exists("abio")) {
            # selecionar os pontos únicos e sem NA
            mask <- abio[[1]]
            # Selecionar pontos espacialmente únicos #
            cell <- cellFromXY(mask, coord)  # get the cell number for each point
            dup <- duplicated(cell)
            pts1 <- coord[!dup, ]  # select the records that are not duplicated
            pts1 <- pts1[!is.na(extract(mask, pts1)), ]  #selecionando apenas pontos que tem valor de raster

            cat(dim(coord)[1] - dim(pts1)[1], "points removed\n")
            cat(dim(pts1)[1], "spatially unique points\n")
            names(pts1) <- c("lon", "lat")#
            return(pts1)
        } else (cat("Indicate the object with the predictive variables"))
    } else (stop("Coordinate table has more than two columns.\nThis table should only have longitude and latitude in this order."))
}


reg.clean <- c()
for (especie in especies) {
    sp.clean <- clean(coordenadas[coordenadas[, "taxon"] == especie, c("lon","lat")], stack_rasters[[1]])
    sp.clean$sp <- especie
    reg.clean <- rbind(reg.clean,sp.clean)
}
#----#

coordenadas <- reg.clean
especies <- unique(coordenadas$sp)
#----#

#foreach(especie = especies,
#        .packages = c("raster", "modelr")) %dopar% {
# algorithmsArray = Mahalanobis;Maxent;GLM;Bioclim;Random Forest;Domain;SVM
coordenadas[coordenadas$sp == especie, c("lon", "lat")]

variaveis_cortadas <- mask(crop(stack_rasters, mascara), mascara)
for (especie in especies) {
    # especies
	ocorrencias <- coordenadas[coordenadas$sp == especie, c("lon", "lat")]
	 do_enm(
	 species_name = especie,
	 occurrences = ocorrencias,
	 predictors = stack_rasters,
	 models_dir = paste0(resultFolder, hashId),
	 ## argumentos de setupsdmdata():
	 #lon = "lon",#caso as colunas estejam nomeadas diferentes dá para botar aqui
	 #lat = "lat",#idem
	 buffer_type = bufferValue,
	 seed = 512,
	 #clean_dupl = T,
	 #clean_nas = F,
	 #geo_filt = F,
	 #geo_filt_dist = NULL,
	 plot_sdmdata = T,
	 n_back = as.numeric(num_points),
	 partition_type = partitiontype,
	 cv_n = as.numeric(repetitions),
	 cv_partitions = as.numeric(partitions),
	 boot_proportion = as.numeric(trainpercent)/100,
	 boot_n = as.numeric(repetitions),
	 #predictors1 = variaveis_cortadas,#aqui não vai servir ainda
	 ## argumentos de do_any()
	 project_model = F,
	 mask = proj_data_json,
	 write_png = T,
	 #argumentos de do_enm():
	 bioclim = algorithmsArray[[4]] == TRUE,
	 maxent = algorithmsArray[[2]] == TRUE,
	 glm = algorithmsArray[[3]] == TRUE,
	 rf = algorithmsArray[[5]] == TRUE,
	 svm.k = algorithmsArray[[7]] == TRUE,#svm agora é svm.k do pacote kernlab
	 svm.e = F,#svm2 agora é svm.e do pacote e1071
	 domain = algorithmsArray[[6]] == TRUE,
	 mahal = algorithmsArray[[1]] == TRUE,
	 #centroid = ...,#NEW! mas é lento, eu não botaria
	 #mindist = ...,#NEW! mas é lento, eu não botaria
	 )
	
	algorithsNames <- c();
	if(algorithmsArray[[1]] == TRUE){
		c(algorithsNames,'mahal')
	}
	if(algorithmsArray[[2]] == TRUE){
		c(algorithsNames, 'maxent')
	}
	if(algorithmsArray[[3]] == TRUE){
		c(algorithsNames, 'glm')
	}
	if(algorithmsArray[[4]] == TRUE){
		c(algorithsNames, 'bioclim')
	}
	if(algorithmsArray[[5]] == TRUE){
		c(algorithsNames, 'rf')
	}
	if(algorithmsArray[[6]] == TRUE){
		c(algorithsNames, 'domain')
	}
	if(algorithmsArray[[7]] == TRUE){
		c(algorithsNames, 'svm')
	}
	
		#gerando os ensembles por algoritmo
	final_model(species_name = especie,
	            algorithms = algorithsNames,
	            select_par = "TSS",
	            select_par_val = tss,
	            models_dir = paste0("./",resultFolder, hashId),
	            which_models = c("cut_mean_th"), #as opcoes são: "raw_mean",
	            #"bin_mean", "cut_mean", "bin_mean_th", "bin_consensus",
	            #"cut_mean_th", dá para botar várias
	            write_png = T)
	
	#
	#
	#
	
	ensemble_model <- function(species_name,
	occs,
	models_dir = "./models",
	final_dir = "final_models",
	ensemble_dir = "ensemble",
	which_models = c("raw_mean"),
	consensus = FALSE,
	consensus_level = 0.5,
	write_png = T,
	write_raw_map = F) {

	#output folder
	if (file.exists(
		paste0(models_dir, "/", species_name, "/present/", ensemble_dir, "/")) == FALSE) {
		dir.create(paste0(models_dir, "/", species_name, "/present/", ensemble_dir, "/"))
	}

	for (whi in which_models) {
		cat(paste(whi, "-", species_name, "\n")) #lê os arquivos
		tif.files <- list.files(paste0(models_dir, "/", species_name, "/present/",
		final_dir),
		full.names = T, pattern = paste0(whi, ".*tif$"))

		if (length(tif.files) == 0) {
		  cat(paste("No", whi, "models to ensemble from for", species_name, "\n"))
		} else {
		  cat(paste(length(tif.files), whi,
					"models to ensemble from for", species_name, "\n"))
		  mod2 <- raster::stack(tif.files)

		  for(i in 1:length(names(mod2))){
			x = values(mod2[[i]])
			x = na.exclude(x)
			y = (x-min(x))/(max(x)-min(x))
			values(mod2[[i]])[!is.na(values(mod2[[i]]))] = y
		  }

		  #if (length(tif.files) == 1) {
		  #   ensemble.mean <- mod2
		  #} else {
		  ensemble.mean <- raster::overlay(mod2, fun = function(x) {
			return(mean(x, na.rm = T))
		  }
		  )
		  ensemble.sd <- raster::overlay(mod2, fun = function(x) {
			return(sd(x, na.rm = T))
		  }
		  )
		  ensemble.min <- raster::overlay(mod2, fun = function(x) {
			return(min(x, na.rm = T))
		  }
		  )
		  ensemble.max <- raster::overlay(mod2, fun = function(x) {
			return(max(x, na.rm = T))
		  }
		  )
		  ensemble.median <- raster::overlay(mod2, fun = function(x) {
			return(stats::median(x, na.rm = T))
		  }
		  )
		  ensemble.mods <- raster::stack(ensemble.mean, ensemble.median, ensemble.sd,
										 ensemble.min, ensemble.max)
		  names(ensemble.mods) <- c("mean", "median", "sd", "min", "max")

		  coord <- occs[occs$sp == species_name, c("lon", "lat")]

		  if (write_png) {
			png(filename = paste0(models_dir, "/", species_name, "/present/",
								  ensemble_dir, "/", species_name, "_", whi,
								  "_ensemble_mean.png"),
				res = 300, width = 410 * 300 / 72, height = 480 * 300 / 72)
			par(mfrow = c(1, 1), mar = c(4, 4, 0, 0))
			raster::plot(ensemble.mean)
			maps::map("world",
					  c("", "South America"),
					  add = T,
					  col = "grey")
			points(coord, pch = 21, cex = 0.6,
				   bg = scales::alpha("cyan", 0.6))
			dev.off()
		  }
		  if (write_raw_map) {
			png(filename = paste0(models_dir, "/", species_name, "/present/",
								  ensemble_dir, "/", species_name, "_", whi,
								  "_ensemble_without_margins.png"),
				bg = "transparent",
				res = 300, width = 410 * 300 / 72, height = 480 * 300 / 72)
			par(mfrow = c(1, 1), mar = c(0, 0, 0, 0))
			raster::image(ensemble.mean, col = rev(terrain.colors(25)),
						  axes = F, asp = 1)

			dev.off()
		  }

		  raster::writeRaster(ensemble.mods,
							  filename = paste0(models_dir, "/", species_name,
												"/present/",
												ensemble_dir, "/", species_name, "_",
												whi,
												"_ensemble.tif"),
							  bylayer = T,
							  suffix = "names",
							  overwrite = T)

		  #### Consensus models
		  if (consensus == TRUE) {
			ensemble.consensus <- ensemble.mean >= consensus_level
			raster::writeRaster(ensemble.consensus,
								filename = paste0(models_dir, "/", species_name,
												  "/present/",
												  ensemble_dir, "/", species_name,
												  "_", whi,
												  "_ensemble", "_meanconsensus",
												  consensus_level * 100,
												  ".tif"), overwrite = T)


			if (write_png) {
			  png(filename = paste0(models_dir, "/", species_name, "/present/",
									ensemble_dir, "/",
									species_name, "_", whi,
									"_ensemble", "_meanconsensus",
									consensus_level * 100, ".png"), res = 300,
				  width = 410 * 300 / 72, height = 480 * 300 / 72)
			  par(mfrow = c(1, 1), mar = c(4, 4, 0, 0))
			  raster::plot(ensemble.consensus)
			  maps::map("world", c("", "South America"),
						add = T, col = "grey")
			  points(coord, pch = 19, cex = 0.3,
					 col = scales::alpha("cyan", 0.6))
			  dev.off()
			}
			if (write_raw_map) {
			  png(filename = paste0(models_dir, "/", species_name, "/present/",
									ensemble_dir, "/",
									species_name, "_", whi, "_ensemble",
									consensus_level * 100,
									"without_margins.png"),
				  bg = "transparent",
				  res = 300, width = 410 * 300 / 72, height = 480 * 300 / 72)
			  par(mfrow = c(1, 1), mar = c(0, 0, 0, 0))
			  raster::image(ensemble.consensus,
							col = rev(terrain.colors(25)), axes = F, asp = 1)
			  dev.off()
			}
		  }
		}
	}
	print(date())
	}
	#
	#
	#gerando o modelo final
	ensemble_model(species_name = especie,
	               occs = coordenadas,
	               models_dir = paste0("./", resultFolder, hashId),
	               which_models = c("cut_mean_th"),
	               consensus = F,
	               consensus_level = 0.5,
	               write_png = T,#veja se é isso mesmo aqui
	               write_raw_map = T)

	#Criando a tabela com os valores de desempenho do modelo.

	lista <- list.files(paste0('./',resultFolder, hashId ,'/',especie, '/present/partitions'), pattern = ".txt", full.names = T)
	aval <- c()
	for (i in 1:(length(lista) - 1)) {
	    a <- read.table(lista[i])
	    aval <- rbind(aval,a)
	    row.names(aval) <- NULL
	    print(head(aval,10))
	    write.table(aval,
	                paste0("./",resultFolder, hashId, '/', especie, ".csv"),
	                row.names = F, sep = ";")
	}
}